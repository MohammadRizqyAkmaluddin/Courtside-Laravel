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
         Schema::create('booking_sessions', function(Blueprint $table){
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('price');
            $table->index('booking_id');
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
