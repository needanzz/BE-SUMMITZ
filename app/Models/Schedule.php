<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable = [
        'trip_id',
        'departure_date',
        'quota',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}