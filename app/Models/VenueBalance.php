<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueBalance extends Model
{
    protected $table = 'venue_balances';
    protected $fillable = ['venue_id', 'balance'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
}
