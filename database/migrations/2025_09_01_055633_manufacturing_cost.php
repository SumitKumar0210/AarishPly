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
        Schema::create('manufacturing_cost', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('machine_id');
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('product_id');
            $table->integer('qty')->nullable();
            $table->string('size',100)->nullable();
            $table->decimal('rate',10, 2)->nullable();
            $table->decimal('total_amount',10, 2)->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('set null');
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            
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
        Schema::dropIfExists('manufacturing_cost');
    }
};
