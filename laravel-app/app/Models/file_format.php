<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class file_format extends Model
{
    //
    protected $table = 'file_format'; // Specify table name if not plural

    protected $fillable = [
        'idfile',
        'subject_name',
        'exam_duration',
        'code',

    ];
}
