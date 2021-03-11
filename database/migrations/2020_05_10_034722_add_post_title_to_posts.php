<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostTitleToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::defaultStringLength(191);
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->string('post_title')->nullable($value = true);
            $table->integer('is_top_query')->default(0);

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
        try{
            Schema::table('posts', function($table) {
                $table->dropColumn('post_title');
                $table->dropColumn('is_top_query');
             

            });
        }
        catch(\Exception $e){}



    }
}
