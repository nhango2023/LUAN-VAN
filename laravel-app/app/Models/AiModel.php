<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiModel extends Model
{
    use HasFactory;

    protected $table = 'ai_model';

    protected $fillable = [
        'name',
        'api_key',
    ];
}
