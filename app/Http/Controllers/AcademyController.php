<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademyController extends Controller
{
    /**
     * Show all published courses.
     */
    public function index()
    {
        $courses = Course::published()
            ->withCount(['modules', 'lessons'])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($course) {
                $course->progress = $course->getProgressForUser(Auth::user());
                return $course;
            });

        return view('academy.index', compact('courses'));
    }

    /**
     * Show course detail with modules and lessons.
     */
    public function show(Course $course)
    {
        // Allow admin to see draft courses too
        if (!Auth::user()->isAdmin() && $course->status !== 'published') {
            abort(404);
        }

        $course->load(['modules.lessons']);
        $progress = $course->getProgressForUser(Auth::user());

        // Get completed lesson IDs using collection (avoids ambiguous column from hasManyThrough)
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

        // Get completed lesson IDs using collection (avoids ambiguous column)
        $allLessonIds = $course->modules->flatMap(fn($m) => $m->lessons->pluck('id'))->toArray();
        $completedLessonIds = Auth::user()
            ->completedLessons()
            ->whereIn('lesson_id', $allLessonIds)
            ->pluck('lesson_id')
            ->toArray();

        $progress = $course->getProgressForUser(Auth::user());

        // Find next/prev lessons (use already-loaded modules)
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
}
