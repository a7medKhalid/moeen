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
        Schema::create('favourite_audio_files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('khatmah_id')->constrained();
            $table->foreignId('start_verse_id')->constrained('verses');
            $table->foreignId('end_verse_id')->constrained('verses');
            $table->foreignId('audio_file_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_audio_files');
    }
};
