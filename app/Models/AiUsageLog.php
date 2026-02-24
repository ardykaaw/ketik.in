<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUsageLog extends Model
{
    protected $fillable = [
        'user_id',
        'feature_type',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'model',
        'is_success',
        'error_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
