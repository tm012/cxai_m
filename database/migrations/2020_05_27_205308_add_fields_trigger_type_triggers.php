<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTriggerTypeTriggers extends Migration
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
        Schema::table('triggers', function (Blueprint $table) {
            //
            $table->string('trigger_header')->nullable($value = true);
            $table->string('trigger_belong_to')->nullable($value = true);

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
            Schema::table('triggers', function($table) {
                $table->dropColumn('trigger_header');
                $table->dropColumn('trigger_belong_to');
             

            });
        }
        catch(\Exception $e){}


        
    }
}
