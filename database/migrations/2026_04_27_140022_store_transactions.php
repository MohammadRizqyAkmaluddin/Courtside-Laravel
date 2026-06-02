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
        Schema::create('store_transactions', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained();
            $table->integer('total_price');
            $table->enum('payment_method', ['Cash', 'Qris', 'Bank Transfer']);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
