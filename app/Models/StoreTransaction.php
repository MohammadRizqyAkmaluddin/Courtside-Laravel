<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTransaction extends Model
{
    protected $table = 'store_transactions';
    protected $fillable = ['venue_id', 'total_price', 'payment_method'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
}
