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
        Schema::create('hand_tools', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('labour_id');
            $table->unsignedInteger('department_id');
            $table->integer('no_of_item')->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');
            $table->foreign('labour_id')->references('id')->on('labours')->onDelete('set null');
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
        Schema::dropIfExists('hand_tools');
    }
};
