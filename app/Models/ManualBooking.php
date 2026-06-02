<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualBooking extends Model
{
    protected $table = 'manual_bookings';
    protected $fillable = [
        'venue_id',
        'court_id',
        'customer_id',
        'customer_name',
        'booking_date',
        'total_price',
        'payment_type',
        'payment_status',
        'status',
        'code'
    ];

    public function sessions () {
        return $this->hasMany(ManualBookingSession::class, 'manual_booking_id');
    }
    public function additional () {
        return $this->hasMany(ManualBookingAdditional::class, 'manual_booking_id');
    }
}
