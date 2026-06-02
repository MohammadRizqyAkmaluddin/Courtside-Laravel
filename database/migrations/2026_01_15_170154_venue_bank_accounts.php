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
        Schema::create('venue_bank_accounts', function(Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('bank_account');
            $table->string('holder_name');
            $table->enum('account_type', ['Bank', 'E-Wallet']);
            $table->string('bank_type');
            $table->enum('status', ['Main', 'Other']);
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
