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
        Schema::create('booking_hold_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_hold_header_id')->constrained()->cascadeOnDelete();
            $table->foreignId('additional_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
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
