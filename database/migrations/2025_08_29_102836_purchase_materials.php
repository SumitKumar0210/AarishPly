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
        Schema::create('purchase_materials', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('purchase_order_id');
            $table->integer('qty')->nullable();
            $table->decimal('rate',10, 2)->nullable();
            $table->string('size', 225)->nullable();
            $table->integer('actual_qty')->nullable();
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('set null');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');

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
        Schema::dropIfExists('purchase_materials');
    }
};
