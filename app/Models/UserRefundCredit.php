<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRefundCredit extends Model
{
    protected $table = 'user_refund_credits';
    protected $fillable = ['user_id', 'total_credit'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
