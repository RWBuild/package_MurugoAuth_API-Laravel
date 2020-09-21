<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefreshTokenToMurugoUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('murugo_users', function (Blueprint $table) {
//            $table->text('refresh_token')->after('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('murugo_users', function (Blueprint $table) {
//            $table->dropColumn('refresh_token');
        });
    }
}
