<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name',
        'permission_name', 
        'permission_value',
        'role_head', 
    ];

    public $timestamps = false;
}
