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
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus kolom status
            $table->dropColumn('status');

            // Tambahkan kolom baru
            $table->string('customer_name')->after('schedule_id');
            $table->string('customer_email')->after('customer_name');
            $table->integer('quantity')->after('customer_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kembalikan status
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            // Hapus kolom baru
            $table->dropColumn(['customer_name', 'customer_email', 'quantity']);
        });
    }
};
