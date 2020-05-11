<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('murugo_user_avatar', 255)->nullable()->after('murugo_user_id');
            $table->string('murugo_user_public_name', 255)->nullable()->after('murugo_user_avatar');
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
            $table->dropColumn('murugo_user_avatar');
            $table->dropColumn('murugo_user_public_name');
        });
    }
}
