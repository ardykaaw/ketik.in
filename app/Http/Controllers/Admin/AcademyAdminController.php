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
    //  COURSES LIST
    // ==========================================

    public function index()
    {
        $courses = Course::withCount(['modules', 'lessons'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.academy.index', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        \Log::info('storeCourse called', $request->only('title', 'description'));

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'access_type' => 'nullable|string',
                'cover_image' => 'nullable|image|max:51200',
            ]);
            \Log::info('storeCourse validation passed', $validated);

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'access_type' => $request->access_type ?? 'all',
                'status' => 'draft',
                'sort_order' => (Course::max('sort_order') ?? 0) + 1,
            ];

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('courses/covers', 'public');
                \Log::info('storeCourse cover uploaded', ['path' => $data['cover_image']]);
            }

            $course = Course::create($data);
            \Log::info('storeCourse created', ['course_id' => $course->id]);

            return redirect()->route('admin.academy.index')->with('success', 'E-Course berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('storeCourse validation failed', ['errors' => $e->errors()]);
            return redirect()->route('admin.academy.index')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Gagal validasi: ' . collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            \Log::error('storeCourse exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('admin.academy.index')
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function destroyCourse(Course $course)
    {
        if ($course->cover_image) {
            Storage::disk('public')->delete($course->cover_image);
        }
        foreach ($course->modules as $module) {
            if ($module->thumbnail) Storage::disk('public')->delete($module->thumbnail);
            foreach ($module->lessons as $lesson) {
                if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
                if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
            }
        }
        $course->delete();

        return redirect()->route('admin.academy.index')->with('success', 'E-Course berhasil dihapus!');
    }

    // ==========================================
    //  COURSE DETAIL (Modules Management)
    // ==========================================

    public function show(Course $course)
    {
        $modules = $course->modules()->withCount('lessons')->orderBy('sort_order')->get();
        return view('admin.academy.show', compact('course', 'modules'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'access_type' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->only('title', 'description', 'status');
        if ($request->has('access_type')) {
            $data['access_type'] = $request->access_type;
        }

        $course->update($data);

        return redirect()->route('admin.academy.show', $course)->with('success', 'Pengaturan Academy diperbarui!');
    }

    // ==========================================
    //  MODULES
    // ==========================================

    public function storeModule(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:51200',
        ]);

        $data = [
            'title' => $request->title,
            'sort_order' => ($course->modules()->max('sort_order') ?? 0) + 1,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('modules/thumbnails', 'public');
        }

        $course->modules()->create($data);

        return redirect()->route('admin.academy.show', $course)->with('success', 'Modul berhasil ditambahkan!');
    }

    public function updateModule(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:51200',
        ]);

        $data = ['title' => $request->title];

        if ($request->hasFile('thumbnail')) {
            if ($module->thumbnail) {
                Storage::disk('public')->delete($module->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('modules/thumbnails', 'public');
        }

        if ($request->input('remove_thumbnail') === '1' && $module->thumbnail) {
            Storage::disk('public')->delete($module->thumbnail);
            $data['thumbnail'] = null;
        }

        $module->update($data);
        return redirect()->route('admin.academy.show', $module->course)->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroyModule(Module $module)
    {
        if ($module->thumbnail) {
            Storage::disk('public')->delete($module->thumbnail);
        }
        foreach ($module->lessons as $lesson) {
            if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
            if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
        }
        $courseId = $module->course_id;
        $module->delete();
        return redirect()->route('admin.academy.show', $courseId)->with('success', 'Modul berhasil dihapus!');
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
            'video_file' => 'nullable|mimes:mp4,webm,ogg,mov|max:102400',
            'document_file' => 'nullable|mimes:pdf,doc,docx|max:71680',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'sort_order' => ($module->lessons()->max('sort_order') ?? 0) + 1,
        ];

        if ($request->hasFile('video_file')) {
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
            $data['video_url'] = null;
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $data['file_path'] = $file->store('lessons/documents', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $module->lessons()->create($data);

        return redirect()->route('admin.academy.show', $module->course)->with('success', 'Materi berhasil ditambahkan!');
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
            'document_file' => 'nullable|mimes:pdf,doc,docx|max:71680',
        ]);

        $data = $request->only('title', 'content', 'video_url');

        if ($request->hasFile('video_file')) {
            if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
            $data['video_path'] = $request->file('video_file')->store('lessons/videos', 'public');
            $data['video_url'] = null;
        }

        if ($request->hasFile('document_file')) {
            if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
            $file = $request->file('document_file');
            $data['file_path'] = $file->store('lessons/documents', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        if ($request->input('remove_video') === '1') {
            if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
            $data['video_path'] = null;
            $data['video_url'] = null;
        }

        if ($request->input('remove_document') === '1') {
            if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
            $data['file_path'] = null;
            $data['file_type'] = null;
        }

        $lesson->update($data);

        return redirect()->route('admin.academy.show', $lesson->module->course)->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyLesson(Lesson $lesson)
    {
        if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
        if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
        $courseId = $lesson->module->course_id;
        $lesson->delete();
        return redirect()->route('admin.academy.show', $courseId)->with('success', 'Materi berhasil dihapus!');
    }
}
