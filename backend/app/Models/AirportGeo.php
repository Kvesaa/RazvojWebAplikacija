<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportGeo extends Model
{
    use HasFactory;

    protected $primaryKey = 'airport_id';
    public $timestamps = false;
    protected $table = 'airport_geo';

    protected $fillable = [
        'name',
        'city',
        'country',
        'latitude',
        'longitude',
        'geolocation'
    ];
}
