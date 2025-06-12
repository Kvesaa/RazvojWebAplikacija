<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightLog extends Model
{
    use HasFactory;

    protected $table = 'flight_log';
    protected $primaryKey = 'flight_log_id';
    public $timestamps = false;

    protected $fillable = [
        'log_date',
        'user',
        'flightno',
        'from_old',
        'to_old',
        'from_new',
        'to_new',
        'departure_old',
        'arrival_old',
        'departure_new',
        'arrival_new',
        'airplane_id_old',
        'airplane_id_new',
        'airline_id_old',
        'airline_id_new',
        'comment'
    ];
}
