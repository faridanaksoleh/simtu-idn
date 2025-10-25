<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('coordinator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('subject', 200);
            $table->text('message');
            $table->text('response')->nullable();
            $table->enum('status', ['pending', 'replied', 'closed'])->default('pending');
            $table->timestamps();

            $table->index(['student_id', 'coordinator_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_notes');
    }
};
