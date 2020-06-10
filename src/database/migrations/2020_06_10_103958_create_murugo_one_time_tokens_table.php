<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMurugoOneTimeTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('murugo_one_time_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('murugo_user_id');
            $table->text('one_time_token');
            $table->dateTime('expires_at');
            $table->boolean('is_used')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('murugo_one_time_tokens');
    }
}
