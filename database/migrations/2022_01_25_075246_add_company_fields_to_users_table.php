<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->after('user_image')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('website_url')->nullable();
            $table->string('company_phone_no')->nullable();
            $table->string('zipcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('company_logo');
            $table->dropColumn('website_url');
            $table->dropColumn('company_phone_no');
            $table->dropColumn('zipcode');
        });
    }
}
