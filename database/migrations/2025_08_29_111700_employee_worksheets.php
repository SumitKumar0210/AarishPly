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
        Schema::create('employee_worksheets', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('labour_id');
            $table->unsignedInteger('po_id');
            $table->string('shift_type', 10)->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('labour_id')->references('id')->on('labours')->onDelete('set null');
            $table->foreign('po_id')->references('id')->on('packing_lists')->onDelete('set null');

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
        Schema::dropIfExists('employee_worksheets');
    }
};
