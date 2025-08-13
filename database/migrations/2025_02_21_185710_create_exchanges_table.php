<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exchangesnumber');
            $table->string('total_price');
            $table->string('full_name');
            $table->string('phonenumber');

            $table->timestamp('created_at')->useCurrent();
            $table->integer('users_id')->unsigned()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('exchangestypes_id')->unsigned()->nullable();
            $table->foreign('exchangestypes_id')->references('id')->on('exchangestypes')->onDelete('cascade');
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
