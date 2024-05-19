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
        Schema::create('clip_has_verses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('order');

            $table->unsignedBigInteger('start_verse_id');
            $table->unsignedBigInteger('end_verse_id');
            $table->foreignId('audio_file_id')->constrained();
            $table->foreignId('clip_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clip_has_verses');
    }
};
