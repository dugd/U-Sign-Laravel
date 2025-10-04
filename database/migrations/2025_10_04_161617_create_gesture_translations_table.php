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
        Schema::create('gesture_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gesture_id')->constrained('gestures')->cascadeOnDelete();
            $table->string('language_code')->default('en');
            $table->string('title');
            $table->text('description');
            $table->string('video_path'); // шлях в storage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gesture_translations');
    }
};
