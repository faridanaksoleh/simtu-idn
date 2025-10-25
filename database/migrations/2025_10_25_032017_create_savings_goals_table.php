<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('goal_name', 100);
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', ['active', 'completed', 'paused'])->default('active');
            $table->timestamps();

            $table->index(['user_id', 'status', 'deadline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings_goals');
    }
};
