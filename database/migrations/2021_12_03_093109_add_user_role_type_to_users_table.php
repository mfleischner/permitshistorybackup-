<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserRoleTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // added columns to table
            $table->tinyInteger('user_role_type')->after('settings')->comment('Normal = 0, Pro = 1')->default(0);
            $table->string('address1')->after('avatar')->nullable();
            $table->string('address2')->after('address1')->nullable();
            $table->string('country')->after('address2')->nullable();
            $table->string('state')->after('country')->nullable();
            $table->string('city')->after('state')->nullable();
            $table->string('user_image')->after('city')->nullable();
            $table->string('contact',20)->after('user_image')->nullable();
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
            //
            $table->dropColumn('user_role_type');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('user_image');
            $table->dropColumn('contact');
        });
    }
}
