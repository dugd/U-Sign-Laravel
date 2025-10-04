<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('gestures', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('canonical_language_code')->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('gestures');
    }
};
