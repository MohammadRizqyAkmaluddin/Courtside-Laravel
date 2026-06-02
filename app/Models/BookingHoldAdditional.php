<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingHoldAdditional extends Model
{
    protected $table = 'booking_hold_additions';
    protected $fillable = [
        'booking_hold_header_id',
        'additional_id',
        'price'
    ];

    public function header()
    {
        return $this->belongsTo(BookingHoldHeader::class);
    }
    public function additional()
    {
        return $this->belongsTo(Additional::class);
    }
}
