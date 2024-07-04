<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShift extends Model
{
    use HasFactory;

    protected $table = 'users_shifts';

    protected $fillable = [
        'user_id',
        'substitute_user_id',
        'temp_changes',
        'date_from',
        'date_to'
    ];

    protected $casts = [
        'temp_changes' => 'array',
    ];
}
