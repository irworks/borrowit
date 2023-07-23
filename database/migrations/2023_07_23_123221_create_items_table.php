<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('item_stack_id');
            $table->boolean('is_intact');
            $table->timestamps();

            $table->foreign('item_stack_id')->references('id')->on('items');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
