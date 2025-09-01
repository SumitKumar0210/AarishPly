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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('vendor_id');
            $table->decimal('total', 10,2)->nullable();
            $table->decimal('gst_per',10, 2)->nullable();
            $table->decimal('gst_amount', 10, 2)->nullable();
            $table->decimal('cariage_amount', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->decimal('expected_delivery_date', 10, 2)->nullable();
            $table->date('order_date')->nullable();
            $table->smallInteger('credit_days')->nullable();
            $table->longText('material_items')->nullable();
            $table->longText('term_and_conditions')->nullable();
            $table->string('purchase_no')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->tinyInteger('quality_status')->nullable();
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

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
        Schema::dropIfExists('purchase_orders');
    }
};
