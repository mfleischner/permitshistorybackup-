<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaleSearchChangePropertyzipcode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('search', function (Blueprint $table) {
            //
            $table->string('PropertyZipCode',10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('search', function (Blueprint $table) {
            //
            $table->string('PropertyZipCode',5)->nullable()->change();
        });
    }
}
