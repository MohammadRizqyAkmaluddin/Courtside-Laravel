<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Additional extends Model
{
    protected $fillable = ['court_id', 'additional_type_id', 'description', 'price'];

    public $timestamps = false;

    public function additionalType()
    {
        return $this->belongsTo(AdditionalType::class);
    }
    public function booking()
    {
        return $this->hasMany(BookingAdditional::class);
    }
    public function bookingHold()
    {
        return $this->hasMany(BookingHoldAdditional::class);
    }
    public function court()
    {
        return $this->belongsTo(Court::class);
    }
    public function hold()
    {
        return $this->hasMany(BookingHoldAdditional::class);
    }
}
