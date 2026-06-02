<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingSession extends Model
{
    protected $fillable = [
        'booking_id',
        'start_time',
        'end_time',
        'price'
    ];

    public $timestamps = false;

    protected $cast = [
        'booking_date' => 'date'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
