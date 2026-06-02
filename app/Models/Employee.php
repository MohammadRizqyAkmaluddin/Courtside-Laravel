<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['venue_id', 'name', 'position', 'salary', 'bod', 'religion', 'gender', 'phone_number'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
}
