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
        Schema::create('additionals', function(Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->foreignId('additional_type_id')->constrained();
            $table->string('description');
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
