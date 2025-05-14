<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageModel extends Model
{
    //
    protected $table = 'messages';
    protected $fillable = ['seen', 'id_file'];
}
