<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $table = 'airline';
    protected $primaryKey = 'airline_id';
    public $timestamps = false;

    protected $fillable = [
        'iata',
        'airlinename',
        'base_airport'
    ];
}
