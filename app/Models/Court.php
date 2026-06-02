<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = ['venue_id', 'sport_type_id', 'court_type_id', 'court_material_id', 'name', 'session_duration', 'price', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('storage/court/' . $this->image);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function sportType()
    {
        return $this->belongsTo(SportType::class);
    }
    public function courtType()
    {
        return $this->belongsTo(CourtType::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    public function addition()
    {
        return $this->hasMany(Additional::class);
    }
    
    public function ratings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Booking::class,
            'court_id',   // FK di bookings
            'booking_id', // FK di ratings
            'id',         // PK di courts
            'id'          // PK di bookings
        );
    }
}

