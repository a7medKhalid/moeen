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
        Schema::create('segments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('start_time');
            $table->string('end_time');

            $table->string('type');
            $table->unsignedBigInteger('type_id');
            $table->foreignId('audio_file_id')->constrained();

        });
    }
};
