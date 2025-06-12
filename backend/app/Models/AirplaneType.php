<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirplaneType extends Model
{
    use HasFactory;

    protected $primaryKey = 'type_id';
    public $timestamps = false;
    protected $table = 'airplane_type';

    protected $fillable = [
        'identifier',
        'description'
    ];
}
