<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAdditional extends Model
{
    protected $table = 'booking_additions';

    protected $fillable = [
        'booking_id',
        'additional_id',
        'price'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
    public function additional() {
        return $this->belongsTo(Additional::class);
    }
}
