<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCreditTransferRequest extends Model
{
    protected $table = 'user_credit_transfer_requests';
    protected $fillable = ['user_id', 'total_credit', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
