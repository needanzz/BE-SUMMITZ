<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    //
    protected $fillable = [
        'item',
    ];

    public function getTitleAttribute(): string
    {
        return $this->activity;
    }
    
    public function trips()
    {
        return $this->belongsToMany(Trip::class); 
    }
}
