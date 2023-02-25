<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('posts_id')->unsigned();
            $table->unsignedBiginteger('users_id')->unsigned();
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('null');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('Body');
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
        Schema::dropIfExists('comments');
    }
};
