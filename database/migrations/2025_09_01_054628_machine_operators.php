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
        Schema::create('machine_operators', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('machine_id');
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('user_id');
            $table->decimal('runing_hours', 6,2)->nullable();
            $table->text('remark')->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('set null');
            $table->foreign('po_id')->references('id')->on('production_orders')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
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
        Schema::dropIfExists('machine_operators');
    }
};
