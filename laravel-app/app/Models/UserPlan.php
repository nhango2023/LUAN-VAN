<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    //
    use HasFactory;

    // Tên bảng (Laravel sẽ tự động xác định bảng nếu theo convention)
    protected $table = 'user_plan';

    // Các thuộc tính có thể gán đại trà
    protected $fillable = [
        'id_user',
        'id_plan',
        'start_date',
        'end_date',
    ];
}
