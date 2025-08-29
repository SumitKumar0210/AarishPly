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
        Schema::create('grn_purchases', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('purchase_order_id');
            $table->text('note')->nullable();
           
            // Relations
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes(); // in case you need to archive products
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grn_purchases');
    }
};
