<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shareds extends Model
{
    use HasFactory;

    protected $table = 'shareds';
    protected $fillable = [
        'user_id',
        'shareable_id',
        'shareable_type'
    ];
}
