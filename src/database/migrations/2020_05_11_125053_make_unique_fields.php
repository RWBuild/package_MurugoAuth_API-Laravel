<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeUniqueFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->unique()->change();
//            $table->text('token')->nullable(false)->unique()->change();
            $table->string('murugo_user_id')->nullable(false)->change();
            $table->string('name')->nullable(false)->change();
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
            $table->string('email')->change();
//            $table->text('token')->change();
            $table->string('murugo_user_id')->nullable()->change();
            $table->string('name')->nullable()->change();
        });
    }
}
