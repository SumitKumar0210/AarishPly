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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->bigInteger('mobile');
            $table->string('email', 225)->unique();
            $table->string('password',);
            $table->string('city',);
            $table->text('address',);
            $table->unsignedInteger('state_id');
            $table->string('image',225)->nullable();
            $table->unsignedInteger('user_type_id')->nullable();
            $table->string('access_token',225)->nullable();
            $table->string('token_expires_at',20)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
