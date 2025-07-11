<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';
    protected $primaryKey = 'booking_id';
    public $timestamps = false;

    protected $fillable = [
        'flight_id',
        'seat',
        'passenger_id',
        'price'
    ];
}
