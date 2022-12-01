<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'notificationId',
        'assignUsers', 
        'event_name', 
        'url', 
        'complaint_id', 
        'userid'
    ];
}
