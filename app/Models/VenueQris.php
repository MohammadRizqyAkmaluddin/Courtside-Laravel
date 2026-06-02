<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueQris extends Model
{
    protected $table = 'venue_qris';
    protected $fillable = ['venue_id', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute() {
        return asset('storage/qris/' . $this->image);
    }

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
}
