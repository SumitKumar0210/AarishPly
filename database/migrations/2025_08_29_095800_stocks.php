<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing BIGINT primary key
            $table->unsignedInteger('materail_id')->nullable();
            $table->integer('in_stock ')->nullable(); // Increased precision for realistic values
            $table->integer('out_stock')->nullable();  
            $table->smallInteger('status')->nullable();


            // Relations
            $table->foreign('materail_id')->references('id')->on('materails')->onDelete('set null');
          
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks'); 
    }
};
