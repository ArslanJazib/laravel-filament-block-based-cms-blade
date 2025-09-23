<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\BillingController;
use App\Http\Controllers\Student\ProfileController;

// --------------------
// Public Frontend
// --------------------
Route::get('/', [FrontendController::class, 'page'])->name('frontend.home');

// Static & CMS-like pages
Route::get('/pages/{slug}', [FrontendController::class, 'page'])->name('frontend.page');

// Courses (public catalog)
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');
});

// --------------------
// Student Area (auth + role:student)
// --------------------
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');

    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');

    // Enrolled Courses
    Route::prefix('enrolled-courses')->name('student.enrolled.')->group(function () {
        Route::get('/', [StudentCourseController::class, 'index'])->name('index'); // list of enrolled courses
        Route::get('/{course}', [StudentCourseController::class, 'show'])->name('show'); // enrolled course page
        Route::get('/{course}/lesson/{lesson}', [StudentCourseController::class, 'lesson'])->name('lesson'); // load lesson
        Route::post('/{course}/comment/{lesson}', [StudentCourseController::class, 'comment'])->name('comment'); // post comment
        Route::post('/{course}/rate', [StudentCourseController::class, 'rate'])->name('rate'); // rate course
    });

    // Billing
    Route::get('/billing', [BillingController::class, 'index'])->name('student.billing');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('student.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('student.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('student.profile.destroy');
});

// --------------------
// Auth Scaffolding (Breeze)
// --------------------
require __DIR__ . '/auth.php';
