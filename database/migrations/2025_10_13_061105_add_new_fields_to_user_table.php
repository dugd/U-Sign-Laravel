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
        Schema::table('users', function (Blueprint $t) {
            if (!Schema::hasColumn('users','vanity_slug')) {
                $t->string('vanity_slug')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('users','fingerspelling_name')) {
                $t->json('fingerspelling_name')->nullable()->after('vanity_slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            if (Schema::hasColumn('users','vanity_slug')) {
                $t->dropUnique(['users_vanity_slug_unique']);
                $t->dropColumn(['vanity_slug']);
            }
            if (Schema::hasColumn('users','fingerspelling_name'))
                $t->dropColumn(['fingerspelling_name']);
        });
    }
};
