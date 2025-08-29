<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing BIGINT primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('city')->nullable();

            // $table->unsignedBigInteger('state_id')->nullable(); // Define the column first
            // $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->string('zip_code')->nullable();
            $table->text('note')->nullable(); // Use text for longer notes
            $table->smallInteger('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Better for referencing users

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
