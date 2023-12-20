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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circuit_id');
            $table->foreignId('user_id');
            $table->time('result');
            $table->boolean('is_valid');
            $table->timestamp('season');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
