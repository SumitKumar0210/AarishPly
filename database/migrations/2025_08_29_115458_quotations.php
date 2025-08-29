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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('branch_id');
       
            $table->longText('product_ids',20)->nullable();
            $table->string('priority', 10)->nullable();
            $table->integer('store_id')->nullable();
            $$table->string('image', 225)->nullable();
            $table->date('delivery_date', 100)->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
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
        Schema::dropIfExists('quotations');
    }
};
