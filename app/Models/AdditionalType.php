<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalType extends Model
{
    protected $fillable = ['sport_type_id', 'addon'];
    
    public function additional() {
        return $this->hasMany(Additional::class);
    }
}
