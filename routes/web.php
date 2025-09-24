<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Student\BillingController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;

// --------------------
// Public Frontend
// --------------------
Route::get('/', [FrontendController::class, 'page'])->name('frontend.home');
Route::get('/pages/{slug}', [FrontendController::class, 'page'])->name('frontend.page');

// Public Courses
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');
});

// --------------------
// Student Area (auth + role:user)
// --------------------
Route::middleware(['auth', 'role:user'])->group(function () {

    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Enrolled Courses
    Route::prefix('enrolled-courses')->name('student.enrolled.')->group(function () {
        Route::get('/', [StudentCourseController::class, 'index'])->name('index');
        Route::get('/{course}/lesson/{lesson?}', [StudentCourseController::class, 'lesson'])->name('lesson');
        Route::post('/{course}/comment/{lesson}', [StudentCourseController::class, 'comment'])->name('comment');
        Route::post('/{course}/rate', [StudentCourseController::class, 'rate'])->name('rate');
        Route::post('/{course}/progress/{lesson}', [StudentCourseController::class, 'updateProgress'])->name('progress.update');
    });

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('student.billing');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('student.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('student.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('student.profile.destroy');

    // Streaming (secured for logged-in users only)
    Route::get('/stream/{filename}', [StreamingController::class, 'stream'])->name('video.stream');
});

// --------------------
// Auth (Breeze)
// --------------------
require __DIR__ . '/auth.php';
