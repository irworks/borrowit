<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            $table->foreignId('organisation_id')->nullable();
            $table->foreignId('user_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('fulfilled_at')->nullable();
            $table->timestamps();

            $table->foreign('organisation_id')->references('id')->on('organisations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
