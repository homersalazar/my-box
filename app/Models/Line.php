<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'header_id',
        'user_id',
        'line_status',
    ];
}
