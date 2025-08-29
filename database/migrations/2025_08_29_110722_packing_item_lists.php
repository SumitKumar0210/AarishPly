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
        Schema::create('packing_item_lists', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->unsignedInteger('packing_list_id');
            $table->unsignedInteger('product_id');
            $table->string('size', 225)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('no_of_cartoon')->nullable();
            $table->text('remark')->nullable();
            $table->tinyInteger('status')->default(0);
           
            // Relations
            $table->foreign('packing_list_id')->references('id')->on('packing_lists')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

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
        Schema::dropIfExists('packing_item_lists');
    }
};
