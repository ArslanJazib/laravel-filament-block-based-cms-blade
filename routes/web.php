<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentTasksController;
use App\Http\Controllers\BlogController;
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

Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blogs.show');
});

Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blogs.category');

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
    Route::get('profile', [ProfileController::class, 'show'])->name('student.profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('student.profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('student.profile.update');
    Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('student.profile.updatePassword');
    Route::post('profile/update-security', [ProfileController::class, 'updateSecurity'])->name('student.profile.updateSecurity');

    // Streaming (secured for logged-in users only)
    Route::get('/stream/', [StreamingController::class, 'stream'])->name('video.stream');
});

// --------------------
// Auth (Breeze)
// --------------------
require __DIR__ . '/auth.php';

// Agentic video generation
Route::middleware(['auth'])->group(function () {
    Route::post('/agent/lessons/{lesson}/video', [AgentTasksController::class, 'renderLessonVideo'])->name('agent.lesson.video');
    Route::post('/agent/video/status', [AgentTasksController::class, 'renderStatus'])->name('agent.video.status');
    Route::post('/agent/courses/{course}/outline', [AgentTasksController::class, 'generateCourseOutline'])->name('agent.course.outline');
    Route::post('/agent/courses/{course}/thumbnail', [AgentTasksController::class, 'generateCourseThumbnail'])->name('agent.course.thumbnail');
    Route::post('/agent/courses/{course}/intro-video', [AgentTasksController::class, 'generateCourseIntroVideo'])->name('agent.course.intro');
    Route::post('/agent/lessons/{lesson}/enhance', [AgentTasksController::class, 'enhanceLesson'])->name('agent.lesson.enhance');
});
