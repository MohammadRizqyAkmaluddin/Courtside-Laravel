<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venue_qris', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        //
    }
};
