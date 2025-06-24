<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //
    protected $fillable = [
        'trip_id',
        'image_path',
    ];

    protected $appends = ['image_urls'];

    public function getImageUrlsAttribute(): array
    {
        return collect($this->image_path)->map(fn($path) => asset('storage/'.$path))->toArray();
    }

    protected $casts = [
        'image_path' => 'array',
    ];


    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
