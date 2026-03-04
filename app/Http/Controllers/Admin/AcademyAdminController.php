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
    //  MAIN INDEX
    // ==========================================

    public function index()
    {
        $course = Course::orderBy('sort_order')->first();

        if (!$course) {
            $course = Course::create([
                'title' => 'Main Academy',
                'slug' => 'main-academy',
                'status' => 'draft',
                'sort_order' => 1
            ]);
        }

        $modules = $course->modules()->withCount('lessons')->orderBy('sort_order')->get();
        return view('admin.academy.index', compact('course', 'modules'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $course->update($request->only('title', 'description', 'status'));

        return redirect()->route('admin.academy.index')->with('success', 'Pengaturan Academy diperbarui!');
    }

    // ==========================================
    //  MODULES
    // ==========================================

    public function storeModule(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'sort_order' => ($course->modules()->max('sort_order') ?? 0) + 1,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('modules/thumbnails', 'public');
        }

        $course->modules()->create($data);

        return redirect()->route('admin.academy.index')->with('success', 'Modul berhasil ditambahkan!');
    }

    public function updateModule(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
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
        return redirect()->route('admin.academy.index')->with('success', 'Modul berhasil diperbarui!');
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
        $module->delete();
        return redirect()->route('admin.academy.index')->with('success', 'Modul berhasil dihapus!');
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
            'document_file' => 'nullable|mimes:pdf,doc,docx|max:20480',
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

        return redirect()->route('admin.academy.index')->with('success', 'Materi berhasil ditambahkan!');
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
            'document_file' => 'nullable|mimes:pdf,doc,docx|max:20480',
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

        return redirect()->route('admin.academy.index')->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroyLesson(Lesson $lesson)
    {
        if ($lesson->video_path) Storage::disk('public')->delete($lesson->video_path);
        if ($lesson->file_path) Storage::disk('public')->delete($lesson->file_path);
        $lesson->delete();
        return redirect()->route('admin.academy.index')->with('success', 'Materi berhasil dihapus!');
    }
}
