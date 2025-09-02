<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('group_id');
            $table->string('name'); 
            $table->smallInteger('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps(); 
            $table->softDeletes(); 

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
