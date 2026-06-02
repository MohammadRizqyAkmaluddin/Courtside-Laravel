<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'venue_id',
        'court_id',
        'user_id',
        'guest_contact',
        'guest_name',
        'booking_date',
        'total_price',
        'start_time',
        'end_time',
        'price',
        'admin_fee',
        'tax',
        'total_price',
        'midtrans_order_id',
        'payment_status',
        'status',
        'code'
    ];

    public function sessions() {
        return $this->hasMany(BookingSession::class);
    }
    public function venue() {
        return $this->belongsTo(Venue::class);
    }
    public function court() {
        return $this->belongsTo(Court::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function rating() {
        return $this->hasOne(Rating::class);
    }
    public function additional() {
        return $this->hasMany(BookingAdditional::class);
    }
    public function cancel() {
        return $this->hasOne(CancelRequest::class);
    }
}
