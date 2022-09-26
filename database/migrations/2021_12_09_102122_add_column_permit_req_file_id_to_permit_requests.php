<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPermitReqFileIdToPermitRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permit_requests', function (Blueprint $table) {
            //
            $table->integer('permit_req_file_id')->after('price_id')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permit_requests', function (Blueprint $table) {
            //
            $table->dropColumn('permit_req_file_id');                       
        });
    }
}
