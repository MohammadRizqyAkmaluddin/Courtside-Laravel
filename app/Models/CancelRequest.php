<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelRequest extends Model
{
    protected $table = 'cancel_requests';
    protected $fillable = ['booking_id', 'status', 'total_refund'];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
