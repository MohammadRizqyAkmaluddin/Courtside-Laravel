<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCart extends Model
{
    protected $table = 'store_carts';
    protected $fillable = ['venue_id', 'store_product_id', 'unit_price', 'quantity', 'subtotal'];

    public $timestamps = false;

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
    public function product() {
        return $this->belongsTo(StoreProduct::class, 'store_product_id', 'id');
    }
}
