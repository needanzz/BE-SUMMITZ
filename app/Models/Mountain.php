<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    //
    protected $fillable = [
        'province_id',
        'mountain_name',
        'description',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}