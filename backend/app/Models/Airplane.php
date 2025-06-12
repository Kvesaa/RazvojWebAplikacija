<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airplane extends Model
{
    use HasFactory;

    protected $table = 'airplane';
    protected $primaryKey = 'airplane_id';
    public $timestamps = false;

    protected $fillable = [
        'capacity',
        'type_id',
        'airline_id'
    ];
}
