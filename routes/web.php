<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\Admin\AcademyAdminController;
use App\Http\Controllers\Admin\InfographicController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/offline', function () {
    return view('offline');
});

// Testing Route for Email Preview
Route::get('/email-preview', function () {
    $user = new \App\Models\User([
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com'
    ]);
    return new \App\Mail\AccountActivated($user);
});

// Device Binding - Dashboard Confirmation
Route::post('/bind-device-confirm', [App\Http\Controllers\Auth\DeviceBindingController::class, 'confirmFromDashboard'])
    ->name('device.binding.confirm')
    ->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Features & Wizard (Premium + Device Bound)
    Route::middleware(['premium', 'device_bound', 'package'])->group(function () {
        // Wizard
        Route::get('/wizard/step-1', [WizardController::class, 'step1'])->name('wizard.step1');
        Route::post('/wizard/step-1', [WizardController::class, 'storeStep1'])->name('wizard.step1.store');
        Route::get('/wizard/step-2', [WizardController::class, 'step2'])->name('wizard.step2');
        Route::post('/wizard/step-2', [WizardController::class, 'storeStep2'])->name('wizard.step2.store');

        Route::get('/story-telling', [FeatureController::class, 'storyTelling'])->name('feature.story-telling');
        Route::post('/story-telling', [FeatureController::class, 'generateStory'])->name('feature.story-telling.generate')->middleware('throttle:ai');
        
        Route::get('/ebook', [FeatureController::class, 'ebook'])->name('feature.ebook');
        Route::post('/ebook', [FeatureController::class, 'generateEbook'])->name('feature.ebook.generate')->middleware('throttle:ai');
        
        Route::get('/opini', [FeatureController::class, 'opini'])->name('feature.opini');
        Route::post('/opini', [FeatureController::class, 'generateOpinion'])->name('feature.opini.generate')->middleware('throttle:ai');
        
        Route::get('/script', [FeatureController::class, 'script'])->name('feature.script');
        Route::post('/script', [FeatureController::class, 'generateScript'])->name('feature.script.generate')->middleware('throttle:ai');
        
        Route::get('/essay', [FeatureController::class, 'essay'])->name('feature.essay');
        Route::post('/essay', [FeatureController::class, 'generateEssay'])->name('feature.essay.generate')->middleware('throttle:ai');
        
        Route::get('/e-kinerja', [FeatureController::class, 'eKinerja'])->name('feature.e-kinerja');
        Route::post('/e-kinerja', [FeatureController::class, 'generateEKinerja'])->name('feature.e-kinerja.generate')->middleware('throttle:ai');

        Route::get('/e-kinerja-atasan', [FeatureController::class, 'eKinerjaAtasan'])->name('feature.e-kinerja-atasan');
        Route::post('/e-kinerja-atasan', [FeatureController::class, 'generateEKinerjaAtasan'])->name('feature.e-kinerja-atasan.generate')->middleware('throttle:ai');

        Route::get('/berita', [FeatureController::class, 'news'])->name('feature.news');
        Route::post('/berita', [FeatureController::class, 'generateNews'])->name('feature.news.generate')->middleware('throttle:ai');

        Route::get('/kata-sambutan', [FeatureController::class, 'speech'])->name('feature.speech');
        Route::post('/kata-sambutan', [FeatureController::class, 'generateSpeech'])->name('feature.speech.generate')->middleware('throttle:ai');

        Route::get('/social-media', [FeatureController::class, 'socialMedia'])->name('feature.social-media');
        Route::post('/social-media', [FeatureController::class, 'generateSocialMedia'])->name('feature.social-media.generate')->middleware('throttle:ai');

        Route::get('/copywriting', [FeatureController::class, 'copywriting'])->name('feature.copywriting');
        Route::post('/copywriting', [FeatureController::class, 'generateCopywriting'])->name('feature.copywriting.generate')->middleware('throttle:ai');

        // New AI Features (Phase 2 - Now available to all Premium users)
        Route::get('/laporan', [FeatureController::class, 'laporan'])->name('feature.laporan');
        Route::post('/laporan', [FeatureController::class, 'generateLaporan'])->name('feature.laporan.generate')->middleware('throttle:ai');

        Route::get('/sop', [FeatureController::class, 'sop'])->name('feature.sop');
        Route::post('/sop', [FeatureController::class, 'generateSop'])->name('feature.sop.generate')->middleware('throttle:ai');

        Route::get('/surat', [FeatureController::class, 'surat'])->name('feature.surat');
        Route::post('/surat', [FeatureController::class, 'generateSurat'])->name('feature.surat.generate')->middleware('throttle:ai');

        Route::post('/library/{content}/refine', [LibraryController::class, 'refine'])->name('library.refine')->middleware('throttle:ai');

        // Academy (Customer)
        Route::get('/academy', [AcademyController::class, 'index'])->name('academy.index');
        Route::get('/academy/lessons/{lesson}/data', [AcademyController::class, 'getLessonData'])->name('academy.lesson.data');
        Route::get('/academy/{course:slug}', [AcademyController::class, 'show'])->name('academy.show');
        Route::get('/academy/{course:slug}/{lesson}', [AcademyController::class, 'lesson'])->name('academy.lesson');
        Route::post('/academy/lessons/{lesson}/toggle-progress', [AcademyController::class, 'toggleProgress'])->name('academy.toggle-progress');
    });

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{content}', [LibraryController::class, 'show'])->name('library.show');
    Route::put('/library/{content}', [LibraryController::class, 'update'])->name('library.update'); // Add this line
    Route::get('/library/{content}/export', [LibraryController::class, 'exportPdf'])->name('library.export');
    Route::delete('/library/{content}', [LibraryController::class, 'destroy'])->name('library.destroy');
    
    // Attachments
    Route::post('/library/{content}/attachment', [LibraryController::class, 'uploadAttachment'])->name('library.attachment.upload');
    Route::delete('/attachment/{attachment}', [LibraryController::class, 'deleteAttachment'])->name('library.attachment.delete');

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mode Guru (Semua User yang Login)
    Route::prefix('guru')->name('guru.')->middleware('package')->group(function () {
        Route::get('/', [App\Http\Controllers\TeacherController::class, 'index'])->name('index');
        Route::get('/soal', [App\Http\Controllers\TeacherController::class, 'soal'])->name('soal');
        Route::post('/soal/generate', [App\Http\Controllers\TeacherController::class, 'generateSoal'])->name('soal.generate');
        Route::get('/modul', [App\Http\Controllers\TeacherController::class, 'modul'])->name('modul');
        Route::post('/modul/generate', [App\Http\Controllers\TeacherController::class, 'generateModul'])->name('modul.generate');
        Route::get('/rpp', [App\Http\Controllers\TeacherController::class, 'rpp'])->name('rpp');
        Route::post('/rpp/generate', [App\Http\Controllers\TeacherController::class, 'generateRpp'])->name('rpp.generate');
        Route::get('/rekap', [App\Http\Controllers\TeacherController::class, 'rekap'])->name('rekap');
        Route::post('/rekap/generate', [App\Http\Controllers\TeacherController::class, 'generateRekap'])->name('rekap.generate');
        Route::get('/pustaka', [App\Http\Controllers\TeacherController::class, 'pustaka'])->name('pustaka');
        Route::get('/pustaka/{id}', [App\Http\Controllers\TeacherController::class, 'pustakaShow'])->name('pustaka.show');
        Route::delete('/pustaka/{id}', [App\Http\Controllers\TeacherController::class, 'pustakaDestroy'])->name('pustaka.destroy');
    });

    // Admin Group
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

        // Admin Users
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::patch('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Admin Subscriptions
        Route::get('/admin/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::post('/admin/subscriptions/{user}/extend', [AdminController::class, 'extendSubscription'])->name('admin.subscriptions.extend');

        // Admin Verifications
        // Admin Verifications
        Route::get('/admin/verifications', [AdminController::class, 'verifications'])->name('admin.verifications');
        Route::post('/admin/verifications/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.verifications.approve');
        Route::post('/admin/verifications/{user}/resend', [AdminController::class, 'resendActivationEmail'])->name('admin.verifications.resend');
        
        // Admin Device Reset
        Route::post('/admin/users/{user}/reset-device', [AdminController::class, 'resetDevice'])->name('admin.users.reset-device');

        // Infographic Generator
        Route::get('/admin/infographic', [InfographicController::class, 'index'])->name('admin.infographic.index');
        Route::post('/admin/infographic/generate', [InfographicController::class, 'generate'])->name('admin.infographic.generate');
        Route::post('/admin/infographic/store-image', [InfographicController::class, 'storeImage'])->name('admin.infographic.store-image');
        Route::delete('/admin/infographic', [InfographicController::class, 'destroy'])->name('admin.infographic.destroy');

        // Academy Management (Multi-Course)
        Route::get('/admin/academy', [AcademyAdminController::class, 'index'])->name('admin.academy.index');
        Route::post('/admin/academy/courses', [AcademyAdminController::class, 'storeCourse'])->name('admin.academy.course.store');
        Route::get('/admin/academy/course/{course}', [AcademyAdminController::class, 'show'])->name('admin.academy.show');
        Route::put('/admin/academy/course/{course}', [AcademyAdminController::class, 'updateCourse'])->name('admin.academy.course.update');
        Route::delete('/admin/academy/course/{course}', [AcademyAdminController::class, 'destroyCourse'])->name('admin.academy.course.destroy');
        Route::post('/admin/academy/course/{course}/modules', [AcademyAdminController::class, 'storeModule'])->name('admin.academy.modules.store');
        Route::put('/admin/academy/modules/{module}', [AcademyAdminController::class, 'updateModule'])->name('admin.academy.modules.update');
        Route::delete('/admin/academy/modules/{module}', [AcademyAdminController::class, 'destroyModule'])->name('admin.academy.modules.destroy');
        
        Route::get('/admin/academy/modules/{module}/lessons/create', [AcademyAdminController::class, 'createLesson'])->name('admin.academy.lessons.create');
        Route::post('/admin/academy/modules/{module}/lessons', [AcademyAdminController::class, 'storeLesson'])->name('admin.academy.lessons.store');
        Route::get('/admin/academy/lessons/{lesson}/edit', [AcademyAdminController::class, 'editLesson'])->name('admin.academy.lessons.edit');
        Route::put('/admin/academy/lessons/{lesson}', [AcademyAdminController::class, 'updateLesson'])->name('admin.academy.lessons.update');
        Route::delete('/admin/academy/lessons/{lesson}', [AcademyAdminController::class, 'destroyLesson'])->name('admin.academy.lessons.destroy');

        // Super Admin Monitoring
        Route::middleware(['superadmin'])->group(function () {
            Route::get('/admin/super', [App\Http\Controllers\SuperAdminController::class, 'index'])->name('admin.super.dashboard');
            Route::get('/admin/super/traffic', [App\Http\Controllers\SuperAdminController::class, 'traffic'])->name('admin.super.traffic');
            Route::get('/admin/super/analytics', [App\Http\Controllers\SuperAdminController::class, 'getAnalyticsData'])->name('admin.super.analytics');
        });
    });
});

require __DIR__.'/auth.php';
