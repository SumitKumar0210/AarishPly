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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('material_id');
            $table->string('size ', 225)->nullable();
            $$table->integer('qty')->nullable();
             $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('po_id')->references('id')->on('production_orders')->onDelete('set null');
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
        Schema::dropIfExists('material_requests');
    }
};
