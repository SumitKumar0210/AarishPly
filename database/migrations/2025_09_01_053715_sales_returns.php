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
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('po_id');
            $table->integer('qty')->nullable();
            $table->text('reason')->nullable();
            $table->string('doc',225)->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('po_id')->references('id')->on('production_orders')->onDelete('set null');
            
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
        Schema::dropIfExists('sales_returns');
    }
};
