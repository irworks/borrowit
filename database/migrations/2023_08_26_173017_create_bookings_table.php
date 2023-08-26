<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->foreignId('organisation_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('manager_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->dateTime('returned_at')->nullable();
            $table->foreignId('reservation_id');
            $table->timestamps();

            $table->foreign('organisation_id')->references('id')->on('organisations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
