<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualBookingAdditional extends Model
{
    protected $table = 'manual_booking_additionals';
    public $timestamps = false;
    protected $fillable = [
        'manual_booking_id',
        'additional_id',
        'price'
    ];

    public function booking()
    {
        return $this->belongsTo(ManualBooking::class);
    }
}
