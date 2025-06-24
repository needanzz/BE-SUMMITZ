<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_itinerary_trip_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('itinerary_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained('itineraries')->cascadeOnDelete();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_trip');
    }
};
