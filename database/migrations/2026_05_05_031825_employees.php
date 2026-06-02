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
        Schema::create('employees', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('gender', ['M', 'F']);
            $table->date('bod');
            $table->string('religion');
            $table->string('phone_number');
            $table->string('position');
            $table->integer('salary');
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
