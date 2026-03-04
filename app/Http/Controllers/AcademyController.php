<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademyController extends Controller
{
    /**
     * Show modules directly (single-page view).
     */
    public function index()
    {
        $course = Course::published()
            ->with(['modules.lessons'])
            ->orderBy('sort_order')
            ->first();

        if (!$course) {
            return view('academy.index', ['course' => null]);
        }

        $progress = $course->getProgressForUser(Auth::user());
        
        $allLessonIds = $course->modules->flatMap(fn($m) => $m->lessons->pluck('id'))->toArray();
        $completedLessonIds = Auth::user()
            ->completedLessons()
            ->whereIn('lesson_id', $allLessonIds)
            ->pluck('lesson_id')
            ->toArray();

        return view('academy.index', compact('course', 'progress', 'completedLessonIds'));
    }

    /**
     * Show course detail with modules and lessons.
     */
    public function show(Course $course)
    {
        if (!Auth::user()->isAdmin() && $course->status !== 'published') {
            abort(404);
        }

        $course->load(['modules.lessons']);
        $progress = $course->getProgressForUser(Auth::user());

        $allLessonIds = $course->modules->flatMap(fn($m) => $m->lessons->pluck('id'))->toArray();
        $completedLessonIds = Auth::user()
            ->completedLessons()
            ->whereIn('lesson_id', $allLessonIds)
            ->pluck('lesson_id')
            ->toArray();

        return view('academy.show', compact('course', 'progress', 'completedLessonIds'));
    }

    /**
     * Show a single lesson.
     */
    public function lesson(Course $course, Lesson $lesson)
    {
        if (!Auth::user()->isAdmin() && $course->status !== 'published') {
            abort(404);
        }

        $course->load(['modules.lessons']);
        $isCompleted = $lesson->isCompletedBy(Auth::user());

        $allLessonIds = $course->modules->flatMap(fn($m) => $m->lessons->pluck('id'))->toArray();
        $completedLessonIds = Auth::user()
            ->completedLessons()
            ->whereIn('lesson_id', $allLessonIds)
            ->pluck('lesson_id')
            ->toArray();

        $progress = $course->getProgressForUser(Auth::user());

        $allLessons = $course->modules
            ->sortBy('sort_order')
            ->flatMap(fn($m) => $m->lessons->sortBy('sort_order'))
            ->values();

        $currentIndex = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        return view('academy.lesson', compact(
            'course', 'lesson', 'isCompleted', 'completedLessonIds',
            'progress', 'prevLesson', 'nextLesson'
        ));
    }

    /**
     * Toggle lesson completion (AJAX).
     */
    public function toggleProgress(Lesson $lesson)
    {
        $user = Auth::user();
        $existing = $user->completedLessons()->where('lesson_id', $lesson->id)->first();

        if ($existing) {
            $user->completedLessons()->detach($lesson->id);
            $completed = false;
        } else {
            $user->completedLessons()->attach($lesson->id, ['completed_at' => now()]);
            $completed = true;
        }

        $course = $lesson->module->course;
        $progress = $course->getProgressForUser($user);

        return response()->json([
            'success' => true,
            'completed' => $completed,
            'progress' => $progress,
        ]);
    }

    /**
     * Get lesson data for modal (AJAX).
     */
    public function getLessonData(Lesson $lesson)
    {
        if (!Auth::user()->isAdmin() && $lesson->module->course->status !== 'published') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $module = $lesson->module;

        return response()->json([
            'title' => $lesson->title,
            'content' => $lesson->content,
            'has_video' => $lesson->has_video,
            'video_type' => $lesson->video_type,
            'video_url' => $lesson->video_file_url,
            'embed_url' => $lesson->embed_url,
            'has_file' => $lesson->has_file,
            'file_url' => $lesson->file_url,
            'file_type' => $lesson->file_type,
            'file_extension' => $lesson->file_extension,
            'is_completed' => $lesson->isCompletedBy(Auth::user()),
            'course_slug' => $module->course->slug,
            'module_title' => $module->title,
            'module_thumbnail' => $module->thumbnail ? asset('storage/' . $module->thumbnail) : null,
        ]);
    }
}
