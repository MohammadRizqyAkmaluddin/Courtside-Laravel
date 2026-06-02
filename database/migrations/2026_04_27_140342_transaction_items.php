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
        Schema::create('transaction_items', function(Blueprint $table) {
            $table->id();
            $table->foreignId('store_transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_product_id')->constrained();
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->integer('subtotal');
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
