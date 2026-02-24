<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'url',
        'ip',
        'user_agent',
        'response_time_ms',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
