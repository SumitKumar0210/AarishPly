<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id(); // Auto-incrementing BIGINT primary key
            $table->string('name', 100);
            $table->decimal('run_hours_at_service', 6, 2)->nullable(); // Increased precision for realistic values
            $table->date('last_maintenance_date')->nullable(); // Removed trailing space
            $table->text('remarks')->nullable(); // Removed trailing space
            $table->samllInteger('cycle_days')->nullable(); 
            $table->samllInteger('cycle_month')->nullable(); 
            $table->longText('message')->nullable(); 
            $table->smallInteger('status')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines'); 
    }
};
