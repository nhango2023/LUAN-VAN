<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalQuestion extends Model
{
    use HasFactory;

    // Tên bảng (Laravel sẽ tự động xác định bảng nếu theo convention)
    protected $table = 'additional_questions';

    // Các thuộc tính có thể gán đại trà
    protected $fillable = [
        'price',
        'isActive'
    ];
}
