<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('date');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('payment_method', ['transfer', 'tunai', 'qris'])->nullable();
            $table->string('payment_proof', 255)->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_note')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'category_id', 'status', 'date', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
