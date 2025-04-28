<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configweb extends Model
{
    protected $table = 'configweb'; // Specify table name if not plural

    protected $fillable = [
        'logo',
        'company_description',
        'address',
        'phone_number',
        'email',
        'facebook_link',
        'title',
        'keywords',
        'web_description',
        'isUse',
        'created_at',
        'updated_at',
    ];
}
