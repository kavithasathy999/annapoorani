<?php

namespace App\Http\Controllers;

use App\Mail\EstimateMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address'      => 'required|string|max:500',
            'state'        => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'area'         => 'nullable|string|max:100',
            'pincode'      => 'nullable|string|max:20',
            'cart_data'    => 'required|string',
            'sub_total'    => 'required|numeric',
            'total'        => 'required|numeric',
        ]);

        $cartItems = json_decode($request->cart_data, true);

        if (empty($cartItems) || !is_array($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty or contains invalid data. Please add items before ordering.'
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($request, $cartItems) {

                $lastId     = DB::table('product_orders')->lockForUpdate()->max('id') ?? 0;
                $newOrderId = 'order' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);

                $customer = Customer::create([
                    'user_id'      => null,
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'phone_number' => $request->phone_number,
                    'address'      => $request->address,
                    'state'        => $request->state,
                    'city'         => $request->city,
                    'pincode'      => $request->pincode,
                ]);

                $order = Order::create([
                    'order_no'  => $newOrderId,
                    'customer_id'   => $customer->id,
                    'sub_total' => $request->sub_total,
                    'shipping' => 0,
                    'discount' => 0,
                    'total'     => $request->total,
                    'status'    => 'Pending',
                    'order_type' => 'ONLINE',
                    'order_date' => now()->format('Y-m-d')
                ]);

                foreach ($cartItems as $item) {
                    OrderSlot::create([
                        'order_id'      => $order->id,
                        'user_id'       => $customer->id,
                        'product_id'    => $item['product_id'],
                        'product_name'  => $item['product_name'],
                        'product_total' => $item['total'],
                        'qty'           => $item['qty'],
                    ]);
                }

                return $newOrderId;
            });

            // ── Compute totals ──
            $netTotal    = (float) $request->total;
            $actualTotal = collect($cartItems)->sum(
                fn($i) => (float)($i['actual'] ?? $i['price']) * (int)$i['qty']
            );

            // ── Send confirmation email ──
            try {
                $payment = \App\Models\PaymentSetting::first() ?? new \App\Models\PaymentSetting();
                
                $globalCharges = \Illuminate\Support\Facades\DB::table('settings')
                    ->whereIn('setting_key', [
                        'extra_charge_1_name', 'extra_charge_1_amount',
                        'extra_charge_2_name', 'extra_charge_2_amount'
                    ])
                    ->pluck('setting_value', 'setting_key')
                    ->toArray();

                Mail::to($request->email)->send(new EstimateMail(
                    orderId:       $result,
                    cartItems:     $cartItems,
                    netTotal:      $netTotal,
                    actualTotal:   $actualTotal,
                    customerName:  $request->name,
                    customerEmail: $request->email,
                    payment:       $payment,
                    globalCharges: $globalCharges,
                ));
            } catch (\Throwable $e) {
                Log::warning('Order confirmation email failed: ' . $e->getMessage());
                // Mail failure does NOT block the order
            }

            // ── Store in session for success page ──
            session([
                'order_success' => [
                    'order_id'     => $result,
                    'cart_items'   => $cartItems,
                    'net_total'    => $netTotal,
                    'actual_total' => $actualTotal,
                ]
            ]);

            return response()->json([
                'success'      => true,
                'order_id'     => $result,
                'redirect_url' => route('order.success'),
                'message'      => 'Order placed successfully!'
            ]);

        } catch (\Throwable $e) {
            Log::error('Order placement failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Order placement failed. Please try again.'
            ], 500);
        }
    }

    public function success()
    {
        $data = session('order_success');

        if (!$data) {
            return redirect('/');
        }

        session()->forget('order_success');

        $payment = \App\Models\PaymentSetting::first() ?? new \App\Models\PaymentSetting();
        $mainUrl = rtrim(env('MAIN_URL', ''), '/');

        // Prepare Base64 QR images to avoid CORS issues in PDF generator
        $gpay_qr_base64 = null;
        if ($payment->gpay_qr_code) {
            try {
                $url = $mainUrl . '/' . ltrim($payment->gpay_qr_code, '/');
                $response = \Illuminate\Support\Facades\Http::get($url);
                if ($response->successful()) {
                    $gpay_qr_base64 = 'data:image/png;base64,' . base64_encode($response->body());
                }
            } catch (\Exception $e) { \Log::error("PDF QR Error (GPay): " . $e->getMessage()); }
        }

        $phonepe_qr_base64 = null;
        if ($payment->phonepe_qr_code) {
            try {
                $url = $mainUrl . '/' . ltrim($payment->phonepe_qr_code, '/');
                $response = \Illuminate\Support\Facades\Http::get($url);
                if ($response->successful()) {
                    $phonepe_qr_base64 = 'data:image/png;base64,' . base64_encode($response->body());
                }
            } catch (\Exception $e) { \Log::error("PDF QR Error (PhonePe): " . $e->getMessage()); }
        }

        return view('pages.order-success', [
            'order_id'    => $data['order_id'],
            'cartItems'   => $data['cart_items'],
            'netTotal'    => $data['net_total'],
            'actualTotal' => $data['actual_total'],
            'payment'     => $payment,
            'gpay_qr'     => $gpay_qr_base64,
            'phonepe_qr'  => $phonepe_qr_base64,
        ]);
    }

    public function invoicePdf($order_id)
    {
        $order = Order::where('order_no', $order_id)->orWhere('id', $order_id)->firstOrFail();
        $cachePath = storage_path('app/public/invoices/Estimate-' . $order->order_no . '.pdf');

        if (!file_exists($cachePath)) {
            $customer = Customer::find($order->customer_id);
            $items = OrderSlot::where('order_id', $order->id)->get();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', [
                'order' => $order,
                'customer' => $customer,
                'items' => $items
            ]);

            $pdfContent = $pdf->output();
            if (!file_exists(dirname($cachePath))) {
                mkdir(dirname($cachePath), 0755, true);
            }
            file_put_contents($cachePath, $pdfContent);
        }

        if (request()->has('download')) {
            return response()->download($cachePath, 'Estimate-' . $order->order_no . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        return response()->file($cachePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Estimate-' . $order->order_no . '.pdf"'
        ]);
    }
}