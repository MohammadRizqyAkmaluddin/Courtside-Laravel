<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $table = 'store_products';
    protected $fillable = ['venue_id', 'product_type', 'name', 'price', 'stock', 'image'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
    public function cart() {
        return $this->hasMany(StoreCart::class);
    }
    public function transactionItem() {
        return $this->hasMany(TransactionItem::class);
    }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute() {
        return asset('storage/product/' . $this->image);
    }
}
