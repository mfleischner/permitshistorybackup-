<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('first_name')->default(NULL)->nullable();
            $table->string('last_name')->default(NULL)->nullable();
            $table->string('contact_no')->default(NULL)->nullable();
            $table->string('email_address')->default(NULL)->nullable();
            $table->string('purchase_with_in')->default(NULL)->nullable();
            $table->string('property_house_no_prefix')->default(NULL)->nullable();
            $table->string('property_house_no')->default(NULL)->nullable();
            $table->string('property_house_no_suffix')->default(NULL)->nullable();
            $table->string('property_direction')->default(NULL)->nullable();
            $table->string('property_street_name')->default(NULL)->nullable();
            $table->string('property_city')->default(NULL)->nullable();
            $table->string('property_state')->default(NULL)->nullable();
            $table->string('zip_code')->default(NULL)->nullable();
            $table->longText('description')->default(NULL)->nullable();
            $table->string('payment_id')->default(NULL)->nullable();
            $table->string('price_id')->default(NULL)->nullable();
            $table->text('flag')->default(NULL)->nullable();
            $table->enum('status',['0','1','2'])->default(0)->comment('0=pending, 1=in process, 2=completed/found');
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
        Schema::dropIfExists('permit_requests');
    }
}
