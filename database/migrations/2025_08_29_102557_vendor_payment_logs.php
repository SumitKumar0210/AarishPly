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
        Schema::create('vendor_payment_logs', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('purchase_order_id');
            $table->integer('qty')->nullable();
            $table->decimal('amount',10, 2)->nullable();
            $table->date('date')->nullable();
            $table->text('debit_note')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');

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
        Schema::dropIfExists('vendor_payment_logs');
    }
};
