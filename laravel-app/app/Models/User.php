<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $fillable = ['fullname', 'email', 'password', 'level', 'username', 'credit', 'isCreated', 'task_id'];
}
