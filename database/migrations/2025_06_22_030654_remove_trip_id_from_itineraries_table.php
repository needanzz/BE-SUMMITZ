<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            //
            $table->dropForeign(['trip_id']); // kalau ada constraint foreign key
            $table->dropColumn('trip_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('itineraries', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('trip_id'); // rollback
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade'); // rollback foreign
        });
    }
};
