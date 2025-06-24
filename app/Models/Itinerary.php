<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    //
    protected $fillable = [
        'day',
        'activity',
    ];

    protected static ?string $title = 'activity';

    public function getTitleAttribute(): string
    {
        return $this->activity;
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class); 
    }
}
