<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_hold_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('guest_contact')->nullable();
            $table->string('guest_name')->nullable();
            $table->enum('booking_type', ['Manual-booking', 'Self-booking']);
            $table->date('booking_date');
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->string('payment_status')->default('hold');
            $table->datetime('expires_at')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        //
    }
};
