<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingHoldHeader extends Model
{
    protected $table = 'booking_hold_headers';

    protected $fillable = [
        'venue_id',
        'court_id',
        'user_id',
        'guest_contact',
        'guest_name',
        'booking_date',
        'expires_at',
        'order_id',
        'midtrans_order_id',
        'snap_token',
        'payment_status'
    ];
    protected $cast = [
        'booking_date' => 'date',
        'expires_at'   => ''
    ];

    public function hold()
    {
        return $this->hasMany(BookingHold::class, 'booking_hold_header_id');
    }
    public function additional()
    {
        return $this->hasMany(BookingHoldAdditional::class);
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
