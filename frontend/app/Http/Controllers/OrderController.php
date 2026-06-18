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

                Order::create([
                    'oeder_id'  => $newOrderId,
                    'user_id'   => $customer->id,
                    'sub_total' => $request->sub_total,
                    'total'     => $request->total,
                    'status'    => 'Pending',
                    'name'      => $request->name,
                    'address'   => $request->address,
                    'state'     => $request->state,
                    'city'      => $request->city,
                    'pincode'      => $request->pincode,
                    'order_source' => 'online',
                ]);

                foreach ($cartItems as $item) {
                    OrderSlot::create([
                        'order_id'      => $newOrderId,
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
                
                Mail::to($request->email)->send(new EstimateMail(
                    orderId:       $result,
                    cartItems:     $cartItems,
                    netTotal:      $netTotal,
                    actualTotal:   $actualTotal,
                    customerName:  $request->name,
                    customerEmail: $request->email,
                    payment:       $payment,
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
}