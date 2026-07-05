<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:255',
            'phone' => 'required|string|regex:/^(?:\+91)?[6-9]\d{9}$/',
            'email' => 'required|email|max:255',
            'address' => 'required|string|min:10',
            'state' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'city' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'pincode' => 'required|numeric|digits:6',
        ]);


        // Generate 4-digit OTP
        $otp = random_int(1000, 9999);

        // Store OTP and user details in session
        session()->put('checkout_otp_data', [
            'otp' => $otp,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'state' => $request->state,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'expires_at' => now()->addMinutes(10)
        ]);

        // Return OTP in Response instead of Email
        try {
            return response()->json([
                'success' => true,
                'message' => 'OTP generated successfully.',
                'otp' => $otp
            ]);
        } catch (\Exception $e) {
            Log::error('OTP generation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate OTP. Please try again later.'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:4',
            'cart_data' => 'required|json',
            'sub_total' => 'required|numeric',
            'total' => 'required|numeric',
            'additional_charge_type' => 'nullable|string',
            'additional_charge_amount' => 'nullable|numeric',
        ]);

        $sessionData = session()->get('checkout_otp_data');

        if (!$sessionData) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please request a new OTP.'
            ], 400);
        }

        if (now()->greaterThan($sessionData['expires_at'])) {
            session()->forget('checkout_otp_data');
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.'
            ], 400);
        }

        if ((int)$request->otp !== (int)$sessionData['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 400);
        }

        // OTP is correct. Process the Order in a DB transaction
        DB::beginTransaction();
        try {
            // Generate Order ID
            $latestOrder = Order::orderBy('id', 'DESC')->first();
            $orderId = 'order' . str_pad($latestOrder ? $latestOrder->id + 1 : 1, 5, "0", STR_PAD_LEFT);

            // Create or Update Customer
            $normalizedPhone = preg_replace('/^\+91/', '', $sessionData['phone']);
            $customer = Customer::where('phone_number', 'LIKE', '%' . $normalizedPhone)->first();
            
            if ($customer) {
                $customer->update([
                    'name' => $sessionData['name'],
                    'email' => $sessionData['email'],
                    'address' => $sessionData['address'],
                    'state' => $sessionData['state'],
                    'city' => $sessionData['city'],
                    'pincode' => $sessionData['pincode'],
                ]);
            } else {
                $customer = Customer::create([
                    'name' => $sessionData['name'],
                    'email' => $sessionData['email'],
                    'phone_number' => $sessionData['phone'],
                    'address' => $sessionData['address'],
                    'state' => $sessionData['state'],
                    'city' => $sessionData['city'],
                    'pincode' => $sessionData['pincode'],
                ]);
            }

            // Create Order
            $order = Order::create([
                'order_no' => $orderId,
                'customer_id' => $customer->id,
                'sub_total' => $request->sub_total,
                'shipping' => $request->additional_charge_amount ?: 0,
                'discount' => 0,
                'total' => $request->total,
                'additional_charge_type' => $request->additional_charge_type,
                'additional_charge_amount' => $request->additional_charge_amount ?: 0,
                'order_type' => 'ONLINE',
                'status' => 'Pending',
                'order_date' => now()->format('Y-m-d')
            ]);

            // Create Order Slots
            $cartData = json_decode($request->cart_data, true);
            foreach ($cartData as $item) {
                OrderSlot::create([
                    'order_id' => $order->id,
                    'user_id' => $customer->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'] ?? 'Unknown',
                    'qty' => $item['qty'],
                    'product_total' => $item['total']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create order records: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process order on our end. Please try again.'
            ], 500);
        }

        // Clear OTP session
        session()->forget('checkout_otp_data');

        $pdfUrl = route('invoice.pdf', ['order_id' => $orderId]);

        // Attempt to send PDF to Admin WhatsApp if API configured
        $adminPhone = env('ADMIN_WHATSAPP_NUMBER', '6380195167');
        $apiUrl = env('WHATSAPP_API_URL');
        $apiToken = env('WHATSAPP_API_TOKEN');

        if ($apiUrl && $apiToken) {
            try {
                $fullPdfUrl = url($pdfUrl);
                \Illuminate\Support\Facades\Http::post($apiUrl, [
                    'token' => $apiToken,
                    'to' => $adminPhone,
                    'document' => $fullPdfUrl,
                    'caption' => "New Order Received: {$orderId}"
                ]);
            } catch (\Exception $e) {
                Log::error('WhatsApp Admin Notification failed: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified and Order placed successfully.',
            'pdf_url' => $pdfUrl
        ]);
    }
}
