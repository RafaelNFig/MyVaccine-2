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
        Schema::create('users', function (Blueprint $table) {
            $table->string('cpf', 14)->primary();
            $table->enum('role', ['admin', 'usuario'])->default('usuario');
            $table->string('name', 100);
            $table->string('password', 255);
            $table->string('email', 100)->unique();
            $table->date('dob');
            $table->string('address', 255);
            $table->string('telephone', 15);
            $table->timestamps();  // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
