<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function lookup($phone)
    {
        $customer = Customer::where('phone_number', $phone)->latest()->first();

        if (!$customer) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found'   => true,
            'name'    => $customer->name,
            'email'   => $customer->email,
            'address' => $customer->address,
            'state'   => $customer->state,
            'city'    => $customer->city,
            'pincode' => $customer->pincode,
        ]);
    }
}