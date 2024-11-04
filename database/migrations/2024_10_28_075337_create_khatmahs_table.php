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
        Schema::create('khatmas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->default('');
            $table->integer('duration')->nullable();
            $table->integer('rounds_counter')->default(0);
            $table->timestamp('last_round_date')->nullable();

            $table->foreignId('bookmark_verse_id')->constrained('verses');
            $table->foreignId('start_verse_id')->constrained('verses');
            $table->foreignId('end_verse_id')->constrained('verses');
            $table->foreignId('user_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khatmahs');
    }
};
