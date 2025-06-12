<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'weatherdata';

    protected $fillable = [
        'log_date',
        'time',
        'station',
        'temp',
        'humidity',
        'airpressure',
        'windspeed',
        'weather',
        'winddirection'
    ];
}
