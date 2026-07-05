<?php

use App\Mail\EstimateMail;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test Data
$orderId = 'TEST-' . strtoupper(bin2hex(random_bytes(3)));
$customerName = 'Test User';
$customerEmail = 'sriramsri1234321@gmail.com';

$cartItems = [
    [
        'product_name' => 'Mega Sky Shot (12 pcs)',
        'price' => 1200.00,
        'qty' => 2,
        'total' => 2400.00
    ],
    [
        'product_name' => 'Sparklers Multi-Color',
        'price' => 150.00,
        'qty' => 5,
        'total' => 750.00
    ]
];

$netTotal = 3150.00;
$actualTotal = 4000.00; // Mocked MRP for savings display

// Fetch Payment Settings
$payment = PaymentSetting::first() ?? new PaymentSetting([
    'bank_name' => 'Test Bank',
    'account_number' => '1234567890',
    'ifsc_code' => 'TEST0001234',
    'account_name' => 'Sri Annapoorani Crackers',
    'gpay_label' => 'Google Pay',
    'gpay_number' => '9876543210',
    'phonepe_label' => 'PhonePe',
    'phonepe_number' => '9876543210'
]);

echo "Attempting to send test email to $customerEmail...\n";

try {
    Mail::to($customerEmail)->send(new EstimateMail(
        $orderId,
        $cartItems,
        $netTotal,
        $actualTotal,
        $customerName,
        $customerEmail,
        $payment
    ));
    echo "Success! Test email sent successfully.\n";
} catch (\Exception $e) {
    echo "Error: Failed to send email. " . $e->getMessage() . "\n";
    echo "Please check your .env file for correct MAIL_MAILER, MAIL_HOST, MAIL_PORT, etc.\n";
}
