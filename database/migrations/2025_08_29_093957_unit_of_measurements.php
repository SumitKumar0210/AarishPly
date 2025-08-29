<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('unit_of_measurements', function (Blueprint $table) {
            $table->id(); // Auto-incrementing BIGINT primary key
            $table->string('name');
            $table->smallInteger('status')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('unit_of_measurements');
    }
};
