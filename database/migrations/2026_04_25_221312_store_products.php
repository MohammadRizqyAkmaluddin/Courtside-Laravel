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
        Schema::create('store_products', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->enum('product_type', ['Fnb', 'Gear']);
            $table->string('name');
            $table->integer('price');
            $table->integer('cogs');
            $table->integer('stock')->nullable();
            $table->string('image')->nullable();
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
