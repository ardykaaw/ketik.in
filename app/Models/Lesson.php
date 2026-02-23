<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['module_id', 'title', 'content', 'video_url', 'video_path', 'sort_order'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'lesson_user')
            ->withPivot('completed_at');
    }

    public function isCompletedBy($user)
    {
        if (!$user) return false;
        return $this->completedByUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if this lesson has any video (uploaded file or external URL).
     */
    public function getHasVideoAttribute()
    {
        return !empty($this->video_path) || !empty($this->video_url);
    }

    /**
     * Get video source type: 'upload', 'embed', or null.
     */
    public function getVideoTypeAttribute()
    {
        if (!empty($this->video_path)) return 'upload';
        if (!empty($this->video_url)) return 'embed';
        return null;
    }

    /**
     * Get the full URL for uploaded video files.
     */
    public function getVideoFileUrlAttribute()
    {
        if (empty($this->video_path)) return null;
        return asset('storage/' . $this->video_path);
    }

    /**
     * Extract YouTube/Vimeo embed URL from various URL formats.
     */
    public function getEmbedUrlAttribute()
    {
        if (empty($this->video_url)) return null;

        $url = $this->video_url;

        // Already an embed URL
        if (str_contains($url, 'youtube.com/embed/') || str_contains($url, 'player.vimeo.com')) {
            return $url;
        }

        // YouTube
        $videoId = null;
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return "https://player.vimeo.com/video/{$matches[1]}";
        }

        return $url;
    }
}
