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
        Schema::table('delivery_orders', function (Blueprint $table) {
            
            $table->string('do_from')->after('do_notes');
            $table->string('do_to')->after('do_from');;
            $table->bigInteger('do_price')->after('do_to');; 
            $table->string('courier_name')->after('do_price');; 
            $table->string('courier_service_name')->after('courier_name');; 
            $table->string('shipping_duration')->after('courier_service_name');; 
            $table->string('shipping_price')->after('shipping_duration');; 
            
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
    }
};
