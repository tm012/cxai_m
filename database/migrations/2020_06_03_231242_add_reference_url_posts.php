<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceUrlPosts extends Migration
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
            $table->string('reference_url')->nullable($value = true);
            

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
                $table->dropColumn('reference_url');
               
             

            });
        }
        catch(\Exception $e){}

        
    }
}
