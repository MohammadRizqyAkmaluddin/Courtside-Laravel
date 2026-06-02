<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $table = 'transaction_items';
    protected $fillable = ['store_transaction_id', 'store_product_id', 'unit_price', 'quantity', 'subtotal'];

    public $timestamps = false;

    public function storeTransaction() {
        return $this->belongsTo(StoreTransaction::class);
    }
    public function product() {
        return $this->belongsTo(StoreProduct::class);
    }
}
