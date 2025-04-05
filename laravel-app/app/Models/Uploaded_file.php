<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uploaded_file extends Model
{
    protected $table = "uploaded_files";
    protected $fillable = ['id_user', 'file_path', 'original_name', 'created_at'];
}
