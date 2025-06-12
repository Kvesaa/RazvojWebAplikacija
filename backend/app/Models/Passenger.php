<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $primaryKey = 'passenger_id';
    public $timestamps = false;

    protected $fillable = [
        'passportno',
        'firstname',
        'lastname'
    ];
}
