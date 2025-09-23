<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name'              => ['required', 'string', 'max:255'],
                'username'          => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'phone'             => ['nullable', 'string', 'max:191'],
                'password'          => ['required', 'confirmed', Rules\Password::defaults()],
                'security_questions'=> ['nullable', 'array'], // JSON
                'company_name'      => ['nullable', 'string', 'max:191'],
                'job_title'         => ['nullable', 'string', 'max:191'],
                'country_id'        => ['nullable', 'exists:countries,id'],
            ]);

            $user = User::create([
                'name'               => $request->name,
                'email'              => $request->email,
                'username'           => $request->username,
                'phone'              => $request->phone,
                'password'           => Hash::make($request->password),
                'security_questions' => $request->filled('security_questions')
                                            ? json_encode($request->security_questions)
                                            : null,
                'company_name'       => $request->company_name,
                'job_title'          => $request->job_title,
                'country_id'         => $request->country_id,
            ]);

            $user->assignRole('user');

            event(new Registered($user));

            Auth::guard('web')->login($user);

            return redirect()
                ->route('courses.index')
                ->with('success', 'Welcome! You are now registered and logged in.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
