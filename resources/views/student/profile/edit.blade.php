@extends('layouts.frontend')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card shadow-sm mb-4">
                <div class="card-header fw-bold">Edit Profile</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="form-control @error('username') is-invalid @enderror">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="job_title" value="{{ old('job_title', $user->job_title) }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" class="form-select">
                                <option value="">Select Country</option>
                                @foreach($countries as $id => $name)
                                    <option value="{{ $id }}" {{ $user->country_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('student.profile.show') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mb-4" id="password-section">
                <div class="card-header fw-bold">Change Password</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.profile.updatePassword') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-danger">Update Password</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm" id="security-section">
                <div class="card-header fw-bold">Security Questions</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.profile.updateSecurity') }}">
                        @csrf

                        @php
                            $existingQuestions = $user->security_questions 
                                ? json_decode($user->security_questions, true) 
                                : [];
                        @endphp

                        @for($i = 0; $i < 3; $i++)
                            <div class="mb-3">
                                <label class="form-label">Security Question {{ $i+1 }}</label>
                                <input type="text" 
                                    name="security_questions[{{ $i }}][question]" 
                                    value="{{ old("security_questions.$i.question", $existingQuestions[$i]['question'] ?? '') }}"
                                    class="form-control @error("security_questions.$i.question") is-invalid @enderror">
                                @error("security_questions.$i.question") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Answer</label>
                                <input type="text" 
                                    name="security_questions[{{ $i }}][answer]" 
                                    value="{{ old("security_questions.$i.answer", $existingQuestions[$i]['answer'] ?? '') }}"
                                    class="form-control @error("security_questions.$i.answer") is-invalid @enderror">
                                @error("security_questions.$i.answer") <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @endfor

                        <button type="submit" class="btn btn-warning">Update Security Questions</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
