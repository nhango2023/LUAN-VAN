<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với tên model (Laravel mặc định là bảng số nhiều của tên model)
    protected $table = 'payments';

    // Các trường có thể được gán giá trị (Mass Assignment)
    protected $fillable = [
        'id_user',
        'id_plan',
        'status',
    ];
}
