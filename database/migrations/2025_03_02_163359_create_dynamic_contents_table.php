<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dynamic_contents', function (Blueprint $table) {
            $table->id();
            $table->string('slot');
            $table->text('content');
            $table->boolean('html')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_contents');
    }
};
