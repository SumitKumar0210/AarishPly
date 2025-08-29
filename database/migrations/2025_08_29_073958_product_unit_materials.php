<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_unit_materials', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('name');
            $table->integer('qty')->unique()->nullable(); // Stock Keeping Unit / Product Code
            $table->string('size')->nullable();
            $table->decimal('rate', 2)->nullable();
            $table->decimal('total_amount', 2)->nullable();
            $table->string('product_type', 150)->nullable();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('material_id');
            $table->tinyInteger('status')->default(1);

            // Relations
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes(); // in case you need to archive products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_unit_materials');
    }
};
