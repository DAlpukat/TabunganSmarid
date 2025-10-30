<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('creditor'); // pihak yang memberi utang
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('due_date')->nullable(); // tanggal jatuh tempo
            $table->boolean('is_paid')->default(false); // status pelunasan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};