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
        Schema::create('production_products', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('grade_id');
            $table->integer('qty',20)->nullable();
            $table->string('size', 225)->nullable();
            $table->string('item_name', 150)->nullable();
            $table->string('modal_no', 150)->nullable();
            $table->string('view_type', 100)->nullable();
            $table->string('unique_code', 100)->nullable();
            $table->date('start_date', 100)->nullable();
            $table->date('delivery_date', 100)->nullable();
            $table->date('image', 225)->nullable();
             $table->tinyInteger('revised')->default(0);
             $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign( 'po_id')->references('id')->on('production_orders')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');

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
        Schema::dropIfExists('production_products');
    }
};
