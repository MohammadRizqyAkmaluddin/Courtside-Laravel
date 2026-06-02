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
        Schema::create('withdrawal_histories', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained();
            $table->foreignId('venue_bank_account_id')->constrained();
            $table->string('reference_id', 14)->unique();
            $table->integer('amount');
            $table->enum('status', ['Pending', 'Processing', 'Success']);
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
