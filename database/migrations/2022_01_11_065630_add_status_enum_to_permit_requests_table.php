<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusEnumToPermitRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permit_requests', function (Blueprint $table) {
            $table->enum('status',['0','1','2','3'])->default(0)->comment('0=not started, 1=submitted, 2=in review, 3=completed/found')->change();
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
            $table->enum('status',['0','1','2'])->default(0)->comment('0=pending, 1=in process, 2=completed/found')->change();
        });
    }
}
