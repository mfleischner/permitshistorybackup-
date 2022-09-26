<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PermitRequestFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_request_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('permit_request_id')->unsigned()->nullable();
            $table->string('file_name')->default(NULL)->nullable();
            $table->enum('status',['0','1'])->default(0)->comment('0=>Active, 1=InActive/Delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permit_request_files', function (Blueprint $table) {
            //
        });

    }
}
