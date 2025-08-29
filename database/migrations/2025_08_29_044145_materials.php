<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedInteger('unit_of_measurement_id');
            $table->string('size', 225)->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Corrected precision and scale
            $table->text('remark')->nullable(); // Removed trailing space
            $table->string('image', 225)->nullable(); // Removed trailing space
            $table->integer('opening_stock')->nullable(); // Removed trailing space
            $table->smallInteger('urgently_required')->nullable(); // Corrected typo: "samllInteger"
            $table->string('tag', 50)->nullable(); // Removed "samllText" and length (text doesn't take length)
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('created_by');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
