<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'koordinator', 'mahasiswa'])->default('mahasiswa');
            $table->string('nim', 20)->nullable()->unique();
            $table->string('major', 100)->nullable();
            $table->string('class', 20)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('photo', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
