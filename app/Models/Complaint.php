<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 
        'subcategory', 
        'dep', 
        'message', 
        'doc', 
        'type', 
        'dep', 
        'nature', 
        'user', 
        'status', 
        'approve_by', 
    ];

    public $timestamps = true;
}
