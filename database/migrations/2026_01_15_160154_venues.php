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
        Schema::create('venues', function(Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('phone');
            $table->text('description');
            $table->text('rules');
            $table->string('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('link_map');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
    }

};
