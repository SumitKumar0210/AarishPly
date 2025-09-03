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
        Schema::create('quotation_products', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('quotation_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('grade_id')->nullable();
            $table->string('size', 225)->nullable();
            $table->integer('qty')->nullable();
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
            $table->foreign('quotation_id')->references('id')->on('quotation_products')->onDelete('set null');
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
        Schema::dropIfExists('quotation_products');
    }
};
