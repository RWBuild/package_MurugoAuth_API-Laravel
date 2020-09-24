<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMurugoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('murugo_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('murugo_user_id');
            $table->string('murugo_user_avatar', 255)->nullable();
            $table->string('murugo_user_public_name', 255)->nullable();
            $table->text('token');
            $table->text('refresh_token')->nullable();;
            $table->timestamp('token_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('murugo_users');
    }
}
