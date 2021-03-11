<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostApprovalToPosts extends Migration
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
           
            $table->integer('is_approval')->default(0);

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
                $table->dropColumn('is_approval');
           
             

            });
        }
        catch(\Exception $e){}
        
    }
}
