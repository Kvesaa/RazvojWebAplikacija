<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $primaryKey = 'employee_id';
    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'birthdate',
        'sex',
        'street',
        'zip',
        'city',
        'emailaddress',
        'telephone',
        'salary',
        'username',
        'password'
    ];
}
