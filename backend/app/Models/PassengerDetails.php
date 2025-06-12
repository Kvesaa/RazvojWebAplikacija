<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'passenger_id';
    public $timestamps = false;
    protected $table = 'passengerdetails';

    protected $fillable = [
        'passenger_id',
        'birthdate',
        'sex',
        'street',
        'city',
        'zip',
        'country',
        'emailaddress',
        'telephone'
    ];
}
