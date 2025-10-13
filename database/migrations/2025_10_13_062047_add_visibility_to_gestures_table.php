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
        Schema::table('gestures', function (Blueprint $table) {
            if (!Schema::hasColumn('gestures','visibility')) {
                $table->enum('visibility', ['public','private'])->default('public')->after('created_by');
            }
            if (!Schema::hasColumn('gestures','created_at')) return;
            $table->index(['created_by','created_at'], 'gestures_user_created_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestures', function (Blueprint $table) {
            if (Schema::hasColumn('gestures','visibility')) $table->dropColumn('visibility');
            $table->dropIndex('gestures_user_created_idx');
        });
    }
};
