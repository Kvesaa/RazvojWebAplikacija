<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $primaryKey = 'flight_id';
    public $timestamps = false;

    protected $fillable = [
        'flightno',
        'from',
        'to',
        'departure',
        'arrival',
        'airline_id',
        'airplane_id'
    ];
}
