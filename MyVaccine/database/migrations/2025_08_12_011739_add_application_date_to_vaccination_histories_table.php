<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('vaccination_histories', function (Blueprint $table) {
        $table->dateTime('application_date')->nullable()->after('batch');
    });
}

public function down()
{
    Schema::table('vaccination_histories', function (Blueprint $table) {
        $table->dropColumn('application_date');
    });
}
};
