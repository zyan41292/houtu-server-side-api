<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = [
        'account',
        'password',
        'name',
        'phone',
        'email',
        'reg_ip',
        'last_ip',
        'last_time',
    ];
}
