<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = 'sms';
    
    protected $fillable = [
        'sender',
        'message',
        'device_id',
        'sim_slot'
    ];

    protected $casts = [
        'sim_slot' => 'integer'
    ];
}
