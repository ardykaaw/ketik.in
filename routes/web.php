<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Testing Route for Email Preview
Route::get('/email-preview', function () {
    $user = new \App\Models\User([
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com'
    ]);
    return new \App\Mail\AccountActivated($user);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Features & Wizard (Premium Only)
    Route::middleware(['premium'])->group(function () {
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

        Route::post('/library/{content}/refine', [LibraryController::class, 'refine'])->name('library.refine')->middleware('throttle:ai');
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
    });
});

require __DIR__.'/auth.php';
