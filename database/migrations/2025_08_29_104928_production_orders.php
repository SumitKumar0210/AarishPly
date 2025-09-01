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
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('quotation_id')->nullable();
            $table->string('batch_no', 50)->nullable();
            $table->text('product_ids',)->nullable();
            $table->string('priority', 20)->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->unsignedInteger('sale_user_id')->nullable();
            $table->string('unique_code', 150)->unique()->nullable();
            $table->string('image', 225)->nullable();

            $table->tinyInteger('revised')->default(0);
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('set null');
             $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('sale_user_id')->references('id')->on('sales_users')->onDelete('set null');

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
        Schema::dropIfExists('production_orders');
    }
};
