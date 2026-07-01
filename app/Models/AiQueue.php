<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AiQueue extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'feature_type',
        'payload',
        'status',
        'error_message',
        'content_id',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
