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
        Schema::create('vaccination_history', function (Blueprint $table) {
            $table->id();
            $table->string('user_cpf', 14);
            $table->foreign('user_cpf')->references('cpf')->on('users')->onDelete('cascade');
            $table->foreignId('vaccine_id')->constrained('vaccines')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->string('batch', 50);
            $table->timestamp('application_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_history');
    }
};
