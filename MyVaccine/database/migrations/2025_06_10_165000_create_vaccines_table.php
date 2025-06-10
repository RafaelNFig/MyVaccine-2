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
        Schema::create('vaccines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('min_age');
            $table->integer('max_age')->nullable();
            $table->text('contraindications')->nullable();
            $table->timestamp('date_up')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccines');
    }
};
