<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('following_user_id');
            $table->boolean('accepted')->default('0');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->unique(['user_id','following_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
