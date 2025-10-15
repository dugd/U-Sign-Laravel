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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'fingerspelling_name')) {
                $table->dropColumn('fingerspelling_name');
            }
            if (!Schema::hasColumn('users', 'fingerspelling_gesture_id')) {
                $table->foreignId('fingerspelling_gesture_id')
                    ->nullable()
                    ->constrained('gestures')
                    ->nullOnDelete()
                    ->after('vanity_slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'fingerspelling_gesture_id')) {
                $table->dropConstrainedForeignId('fingerspelling_gesture_id');
            }
            if (!Schema::hasColumn('users', 'fingerspelling_name')) {
                $table->json('fingerspelling_name')->nullable()->after('vanity_slug');
            }
        });
    }
};
