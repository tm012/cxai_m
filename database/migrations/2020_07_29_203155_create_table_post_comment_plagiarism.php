<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePostCommentPlagiarism extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        ###put -1 to cancel out comment or post
        Schema::defaultStringLength(191);
        Schema::create('post_plagiarism', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->nullable($value = true);
            $table->integer('compare_post_id')->nullable($value = true);
            $table->float('plagiarism', 8, 2)->nullable($value = true);
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
        //
        Schema::dropIfExists('post_plagiarism');
    }
}
