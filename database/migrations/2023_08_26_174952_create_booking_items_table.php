<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->foreignId('booking_id');
            $table->foreignId('item_id');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('item_id')->references('id')->on('items');

            $table->unique(['booking_id', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};
