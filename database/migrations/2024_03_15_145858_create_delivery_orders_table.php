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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->string('do_number')->primary();
            $table->date('do_date');
            $table->string('order_number');
            $table->date('order_date');
            $table->string('cust_name');
            $table->string('cust_phone');
            $table->string('cust_email'); 
            $table->string('cust_address');
            $table->text('do_notes');
            $table->enum('do_status',['Draft','New','Accept','Reject'])->default('New');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('delivery_orders');
    }
};
