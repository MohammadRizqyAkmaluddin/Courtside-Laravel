<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalHistory extends Model
{
    protected $table = 'withdrawal_histories';
    protected $fillable = ['venue_id', 'venue_bank_account_id', 'reference_id', 'amount', 'status'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
    public function bank() {
        return $this->belongsTo(VenueBankAccount::class, 'venue_bank_account_id');
    }
}
