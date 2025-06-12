<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportReachable extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'airport_reachable';

    protected $fillable = ['airport_id', 'hops'];

    public $incrementing = false;
    protected $primaryKey = 'airport_id';
}
