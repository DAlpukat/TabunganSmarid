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
    Schema::create('budgets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('category'); // Makan, Transport, Hiburan, dll
        $table->decimal('amount', 15, 2);
        $table->unsignedInteger('month'); // 1-12
        $table->unsignedInteger('year');
        $table->timestamps();

        $table->unique(['user_id', 'category', 'month', 'year']); // 1 kategori 1 bulan 1 anggaran
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
