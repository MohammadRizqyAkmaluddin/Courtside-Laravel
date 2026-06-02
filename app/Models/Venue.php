<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Venue extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'venues';

    protected $fillable = ['name', 'city_id', 'status', 'email', 'password', 'description', 'rules', 'image', 'address'];

    protected $hidden = ['password'];

    public function city() {
        return $this->belongsTo(City::class);
    }
    public function operationHours() {
        return $this->hasMany(OperationHour::class);
    }
    public function reservationTerm() {
        return $this->hasOne(ReservationTerm::class);
    }
    public function facility() {
        return $this->hasMany(Facility::class);
    }
    public function court() {
        return $this->hasMany(Court::class);
    }
    public function images() {
        return $this->hasMany(VenueImage::class);
    }
    public function firstImage()
    {
        return $this->hasOne(VenueImage::class)->oldestOfMany();
    }
    public function primaryImage()
    {
        return $this->hasOne(VenueImage::class)
            ->where('is_primary', true);
    }
    public function community() {
        return $this->hasMany(Community::class);
    }
    public function booking() {
        return $this->hasMany(Booking::class);
    }
    public function balance() {
        return $this->hasMany(VenueBalance::class);
    }
    public function withdrawal() {
        return $this->hasMany(WithdrawalHistory::class);
    }
    public function bank() {
        return $this->hasMany(VenueBankAccount::class);
    }
    public function store() {
        return $this->hasMany(StoreProduct::class);
    }
    public function cart() {
        return $this->hasMany(StoreCart::class);
    }
    public function storeTransaction() {
        return $this->hasMany(StoreTransaction::class);
    }
    public function qris() {
        return $this->hasOne(VenueQris::class);
    }
    public function employee() {
        return $this->hasMany(Employee::class);
    }

    public function ratings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Booking::class,
            'venue_id',
            'booking_id',
            'id',
            'id'
        );
    }
}
