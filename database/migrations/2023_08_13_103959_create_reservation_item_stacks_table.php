<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservation_item_stacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity');
            $table->foreignId('reservation_id');
            $table->foreignId('item_stack_id');
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('item_stack_id')->references('id')->on('item_stacks');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_item_stacks');
    }
};
