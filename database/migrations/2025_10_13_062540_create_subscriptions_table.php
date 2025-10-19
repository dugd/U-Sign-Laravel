<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('plan', ['vip', 'pro']);

            $table->timestamp('start_date')->useCurrent();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('cancel_date')->nullable();

            $table->json('meta')->nullable();
            $table->timestamps();

            // indexes mega optimization
            $table->index(['user_id','plan']);
            $table->index(['user_id','start_date']);
            $table->index(['user_id','end_date']);
        });
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE subscriptions ADD CONSTRAINT chk_dates CHECK (end_date is null or start_date < end_date);');
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
