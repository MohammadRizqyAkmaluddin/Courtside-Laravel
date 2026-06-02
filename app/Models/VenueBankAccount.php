<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueBankAccount extends Model
{
    protected $table = 'venue_bank_accounts';
    protected $fillable = ['venue_id', 'bank_account', 'holder_name', 'bank_type', 'status'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
    public function bank() {
        return $this->hasMany(WithdrawalHistory::class);
    }
}
