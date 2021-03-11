<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(250);
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('post_id');
            $table->text('post')->nullable($value = true);
            $table->integer('user_id')->default(0);
            $table->integer('trigger_id')->default(0);
            $table->integer('posted_unix_time')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
