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
        Schema::create('grn_purchases', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('dealer_id');
            $table->date('dispatch_date')->nullable();
            $table->string('vehicle_no', 25)->nullable();
            $table->text('note')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('no_of_cartoon')->nullable();
            $table->tinyInteger('status')->default(0);

            // Relations
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');

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
        Schema::dropIfExists('grn_purchases');
    }
};
