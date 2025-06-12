<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airport';
    protected $primaryKey = 'airport_id';
    public $timestamps = false;

    protected $fillable = ['iata', 'icao', 'name'];
}
