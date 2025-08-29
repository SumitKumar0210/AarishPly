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
            $table->integer('modal_id');
            $table->string('item_name', 225)->nullable();
            $table->string('modal_no', 150)->nullable();
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('department_ids');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('sale_user_id');
            $table->string('priority', 10)->nullable();
            $table->text('view_type', 100)->nullable();
            $table->date('start_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('image', 225)->nullable();
            $table->string('unique_code', 50)->nullable();
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('set null');
            $table->foreign('grade_id')->references('id')->on('materials')->onDelete('set null');
            $table->foreign('department_ids')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
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
