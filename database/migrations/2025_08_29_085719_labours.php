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
        Schema::create('labours', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('name');
            $table->decimal('par_hour_cost',10, 2)->nullable();
            $table->decimal('overtime_hourly_rate', 10, 2)->nullable();
            $table->string('image',225)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('department_id');
            $table->tinyInteger('status')->default(1);

            // Relations
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('labours');
    }
};
