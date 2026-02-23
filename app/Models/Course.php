<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'cover_image', 'status', 'sort_order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = static::generateUniqueSlug($course->title);
            }
        });
    }

    /**
     * Generate a unique slug from a title.
     */
    public static function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        $query = static::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $original . '-' . $count++;
            $query = static::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('sort_order');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getProgressForUser($user)
    {
        if (!$user) return 0;

        // Use collection-based approach to avoid ambiguous column issues with hasManyThrough
        $allLessons = $this->modules()->with('lessons')->get()->flatMap(fn($m) => $m->lessons);
        $totalLessons = $allLessons->count();
        if ($totalLessons === 0) return 0;

        $lessonIds = $allLessons->pluck('id')->toArray();
        $completedCount = $user->completedLessons()->whereIn('lesson_id', $lessonIds)->count();

        return round(($completedCount / $totalLessons) * 100);
    }
}
