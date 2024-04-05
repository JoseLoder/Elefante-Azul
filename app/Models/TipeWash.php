<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeWash extends Model
{
    use HasFactory;

    protected $filliable = [
        'description',
        'price',
        'time'
    ];

    public function washes()
    {
        return $this->hasMany(Appointment::class);
    }
}
