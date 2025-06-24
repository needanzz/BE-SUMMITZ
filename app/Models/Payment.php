<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'booking_id',
        'transaction_id',
        'order_id',
        'payment_method',
        'payment_status',
        'fraud_status',
        'gross_amount',
        'paid_at',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
