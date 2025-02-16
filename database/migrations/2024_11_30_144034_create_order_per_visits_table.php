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
        Schema::create('order_per_visits', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('foreach_time_visit_id');
            $table->string('user_id');
            $table->integer('total_bayar');
            $table->enum('status_pembayaran', ['pending', 'success', 'expired'])->default('pending');
            $table->string('status_kehadiran');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_per_visits');
    }
};
