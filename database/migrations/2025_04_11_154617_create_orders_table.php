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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ordersnumber')->unique();
            $table->string('total_price');
            $table->string('full_name');
            $table->string('phonenumber');
            $table->string('address')->nullable();

            $table->timestamp('created_at')->useCurrent();
        
            $table->integer('order_statues_id')->unsigned()->nullable();
            $table->foreign('order_statues_id')->references('id')->on('order_statues')->onDelete('cascade');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
