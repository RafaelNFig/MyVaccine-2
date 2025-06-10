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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('vaccine_id')->constrained('vaccines')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->string('batch', 50);
            $table->date('expiration_date');
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
