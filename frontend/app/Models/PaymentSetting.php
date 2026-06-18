<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $table = 'payment_settings';

    protected $fillable = [
        'page_title',
        'heading',
        'gpay_label',
        'gpay_number',
        'gpay_qr_code',
        'phonepe_label',
        'phonepe_number',
        'phonepe_qr_code',
        'bank_name',
        'account_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'additional_notes',
    ];
}
