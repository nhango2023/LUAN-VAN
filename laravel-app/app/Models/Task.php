<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks";
    protected $fillable = ['id', 'id_user', 'id_file', 'status', 'total_question'];

    // Define the primary key for the model
    protected $primaryKey = 'id';  // The name of the primary key column

    // Set the key type to string (UUID or custom string)
    protected $keyType = 'string';

    // Disable auto-incrementing since we're using custom ID (UUID or other)
    public $incrementing = false;
}
