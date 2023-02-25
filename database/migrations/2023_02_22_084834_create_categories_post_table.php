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
        Schema::create('categories_post', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('posts_id')->unsigned();
            $table->unsignedBiginteger('categories_id')->unsigned();

            $table->foreign('posts_id')->references('id')
                 ->on('posts')->onDelete('cascade');
            $table->foreign('categories_id')->references('id')
                ->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('categories_post');
    }
};
