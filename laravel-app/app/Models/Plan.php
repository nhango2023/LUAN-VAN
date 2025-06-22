<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = 'plans';

    // Các thuộc tính có thể gán đại trà
    protected $fillable = [
        'name',
        'price',
        'processes',
        'questions_limit',
        'description',
        'duration'
    ];
}
