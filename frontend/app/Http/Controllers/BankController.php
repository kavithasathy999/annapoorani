<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $payment = PaymentSetting::first();
        if (!$payment) {
            $payment = new PaymentSetting();
        }
        return view('pages.bank', compact('payment'));
    }
}
