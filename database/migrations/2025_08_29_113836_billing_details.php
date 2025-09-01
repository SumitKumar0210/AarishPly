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
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('bill_id');
            $table->unsignedInteger('product_id');
            $table->integer('qty')->nullable();
            $table->decimal('rate', 22,2)->nullable();
            $table->decimal('amount', 10,2)->nullable();
             $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign( 'bill_id')->references('id')->on('billings')->onDelete('set null');
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
        Schema::dropIfExists('billing_details');
    }
};
