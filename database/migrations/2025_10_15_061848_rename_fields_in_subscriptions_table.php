<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        try {
            DB::statement('ALTER TABLE `subscriptions` DROP CHECK `chk_dates`');
        } catch (\Throwable $e) {}

        Schema::table('subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('subscriptions', 'start_date')) {
                $table->renameColumn('start_date', 'starts_at');
            }
            if (Schema::hasColumn('subscriptions', 'end_date')) {
                $table->renameColumn('end_date', 'ends_at');
            }
            if (Schema::hasColumn('subscriptions', 'cancel_date')) {
                $table->renameColumn('cancel_date', 'canceled_at');
            }
        });

        try {
            DB::statement("
                ALTER TABLE `subscriptions`
                ADD CONSTRAINT `chk_dates`
                CHECK (
                    (starts_at IS NULL OR ends_at IS NULL OR ends_at > starts_at) AND
                    (canceled_at IS NULL OR canceled_at > starts_at)
                )
            ");
        } catch (\Throwable $e) {}
    }

    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `subscriptions` DROP CHECK `chk_dates`');
        } catch (\Throwable $e) {}

        Schema::table('subscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('subscriptions', 'starts_at')) {
                $table->renameColumn('starts_at', 'start_date');
            }
            if (Schema::hasColumn('subscriptions', 'ends_at')) {
                $table->renameColumn('ends_at', 'end_date');
            }
            if (Schema::hasColumn('subscriptions', 'canceled_at')) {
                $table->renameColumn('canceled_at', 'cancel_date');
            }
        });

        try {
            DB::statement("
                ALTER TABLE `subscriptions`
                ADD CONSTRAINT `chk_dates`
                CHECK (
                    (start_date IS NULL OR end_date IS NULL OR end_date > start_date) AND
                    (cancel_date IS NULL OR cancel_date > start_date)
                )
            ");
        } catch (\Throwable $e) {}
    }
};
