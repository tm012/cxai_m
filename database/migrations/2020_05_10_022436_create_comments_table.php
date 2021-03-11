<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(250);
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->text('comment')->nullable($value = true);
            $table->integer('user_id')->default(0);
            $table->integer('trigger_id')->default(0);
            $table->integer('commented_unix_time')->default(0);
            $table->integer('post_id')->default(0);
            $table->integer('parent_comment_id')->default(0);
            $table->integer('vote')->default(0);
            $table->integer('is_verified')->default(0);
            $table->integer('is_best_answer')->default(0);
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
}
