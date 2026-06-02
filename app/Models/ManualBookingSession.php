<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualBookingSession extends Model
{
    protected $table = 'manual_booking_sessions';
    public $timestamps = false;
    protected $fillable = [
        'manual_booking_id',
        'start_time',
        'end_time',
        'price'
    ];

    public function booking()
    {
        return $this->belongsTo(ManualBooking::class, 'manual_booking_id');
    }
}
