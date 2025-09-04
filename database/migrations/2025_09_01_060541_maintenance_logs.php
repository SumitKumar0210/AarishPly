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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('machine_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->text('remark')->nullable();
            $table->tinyInteger('status')->default(0);

           
            // Relations
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('set null');
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
        Schema::dropIfExists('maintenance_logs');
    }
};
