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
        Schema::create('department_change_logs', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('departemt_id');
            $$table->text('reason')->nullable();
            $$table->timestamps('in_date')->nullable();
            $$table->timestamps('out_date')->nullable();
            $$table->string('image', 225)->nullable();

           
            // Relations
            $table->foreign('po_id')->references('id')->on('production_orders')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('departemt_id')->references('id')->on('departemts')->onDelete('set null');

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
        Schema::dropIfExists('department_change_logs');
    }
};
