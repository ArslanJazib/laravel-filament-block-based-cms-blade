<?php

namespace App\Http\Controllers\Student;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('student.profile.show', [
            'user' => auth()->user(),
        ]);
    }

    public function edit()
    {
        return view('student.profile.edit', [
            'user' => auth()->user(),
            'countries' => Country::pluck('name', 'id'),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:191',
            'company_name' => 'nullable|string|max:191',
            'job_title' => 'nullable|string|max:191',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateSecurity(Request $request)
    {
        $request->validate([
            'security_questions'   => 'required|array|size:3',
            'security_questions.*.question' => 'required|string|max:191|distinct',
            'security_questions.*.answer'   => 'required|string|max:191',
        ]);

        $user = auth()->user();

        // Save as JSON
        $user->update([
            'security_questions' => json_encode($request->security_questions),
        ]);

        return back()->with('success', 'Security questions updated successfully.');
    }
}
