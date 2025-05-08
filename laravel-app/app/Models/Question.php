<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";
    protected $fillable = ['id_file', 'content', 'option_1', 'option_2', 'option_3', 'option_4', 'answer', 'level', 'page', 'document'];
}
