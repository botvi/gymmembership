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
        Schema::create('list_membership_gyms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_list');
            $table->integer('harga_list');
            $table->string('durasi');
            $table->json('fasilitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_membership_gyms');
    }
};
