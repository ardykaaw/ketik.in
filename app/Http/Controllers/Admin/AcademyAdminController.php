<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AcademyAdminController extends Controller
{
    // ==========================================
    //  COURSES
    // ==========================================

    public function courses()
    {
        $courses = Course::withCount(['modules', 'lessons'])->orderBy('sort_order')->get();
        return view('admin.academy.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.academy.courses.form');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only('title', 'description', 'status');
        $data['slug'] = Course::generateUniqueSlug($request->title);
        $data['sort_order'] = (Course::max('sort_order') ?? 0) + 1;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.academy.courses')->with('success', 'Kursus berhasil dibuat!');
    }

    public function editCourse(Course $course)
    {
        return view('admin.academy.courses.form', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only('title', 'description', 'status');

        // Update slug if title changed
        if ($course->title !== $request->title) {
            $data['slug'] = Course::generateUniqueSlug($request->title, $course->id);
        }

        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($course->cover_image) {
                Storage::disk('public')->delete($course->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.academy.courses')->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroyCourse(Course $course)
    {
        // Delete cover image
        if ($course->cover_image) {
            Storage::disk('public')->delete($course->cover_image);
        }
        $course->delete();
        return redirect()->route('admin.academy.courses')->with('success', 'Kursus berhasil dihapus!');
    }

    // ==========================================
    //  MODULES
    // ==========================================

    public function modules(Course $course)
    {
        $modules = $course->modules()->withCount('lessons')->get();
        return view('admin.academy.modules.index', compact('course', 'modules'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $request->validate(['title' => 'required|string|max:255']);

        $course->modules()->create([
            'title' => $request->title,
            'sort_order' => ($course->modules()->max('sort_order') ?? 0) + 1,
        ]);

        return redirect()->route('admin.academy.modules', $course)->with('success', 'Modul berhasil ditambahkan!');
    }

    public function updateModule(Request $request, Module $module)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $module->update(['title' => $request->title]);
        return redirect()->route('admin.academy.modules', $module->course)->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroyModule(Module $module)
    {
        $course = $module->course;
        // Delete video files from lessons in this module
        foreach ($module->lessons as $lesson) {
            if ($lesson->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
        }
        $module->delete();
        return redirect()->route('admin.academy.modules', $course)->with('success', 'Modul berhasil dihapus!');
    }

    // ==========================================
    //  LESSONS
    // ==========================================

    public function createLesson(Module $module)
    {
        return view('admin.academy.lessons.form', compact('module'));
    }

    public function storeLesson(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'video_file' => 'nullable|mimes:mp4,webm,ogg,mov|max:102400', // 100MB max
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'sort_order' => ($module->lessons()->max('sort_order') ?? 0) + 1,
        ];

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
            // If uploading file, clear any URL
            $data['video_url'] = null;
        }

        $module->lessons()->create($data);

        return redirect()->route('admin.academy.modules', $module->course)->with('success', 'Materi berhasil ditambahkan!');
    }

    public function editLesson(Lesson $lesson)
    {
        $module = $lesson->module;
        return view('admin.academy.lessons.form', compact('lesson', 'module'));
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'video_file' => 'nullable|mimes:mp4,webm,ogg,mov|max:102400',
        ]);

        $data = $request->only('title', 'content', 'video_url');

        if ($request->hasFile('video_file')) {
            // Delete old video file
            if ($lesson->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
            $data['video_url'] = null; // Clear URL when uploading file
        }

        // If user wants to remove video
        if ($request->input('remove_video') === '1') {
            if ($lesson->video_path) {
                Storage::disk('public')->delete($lesson->video_path);
            }
            $data['video_path'] = null;
            $data['video_url'] = null;
        }

        $lesson->update($data);

        return redirect()->route('admin.academy.modules', $lesson->module->course)->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyLesson(Lesson $lesson)
    {
        $course = $lesson->module->course;
        // Delete video file if exists
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        $lesson->delete();
        return redirect()->route('admin.academy.modules', $course)->with('success', 'Materi berhasil dihapus!');
    }
}
