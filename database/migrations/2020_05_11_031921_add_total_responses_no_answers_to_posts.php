<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalResponsesNoAnswersToPosts extends Migration
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
           
            $table->integer('total_responses')->default(0);
            $table->integer('is_answered')->default(0);

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
                $table->dropColumn('total_responses');
                $table->dropColumn('is_answered');
             

            });
        }
        catch(\Exception $e){}

    }
}
