<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    protected $fillable = ['title',
        'mountain_id',
        'title',
        'duration_day',
        'price',
        'main_image',
        'description',
    ];

    protected $appends = ['main_image_url']; // accessor ini akan ikut di JSON

    public function getMainImageUrlAttribute(): string
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/default.png'); // kalau mau gambar default
    }

    protected $casts = [
        'main_image' => 'array', // atau 'json'
    ];

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function itineraries()
    {
        return $this->belongsToMany(\App\Models\Itinerary::class);
    }


    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
