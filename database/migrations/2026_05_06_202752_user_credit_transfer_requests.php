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
        Schema::create('user_credit_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('total_credit');
            $table->enum('account_type', ['Bank', 'E-Wallet']);
            $table->string('account_number');
            $table->enum('status', ['Requested', 'Processing', 'Success']);
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
