<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrolledCourses = $user->enrollments()
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('user', 'enrolledCourses'));
    }
}
