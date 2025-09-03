<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('sales_users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing BIGINT primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();

            $table->unsignedBigInteger('state_id')->nullable(); // Define the column first

            $table->string('zip_code', 50)->nullable();
            $table->smallInteger('status')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Better for referencing users

            // Relations
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sales_users');
    }
};
