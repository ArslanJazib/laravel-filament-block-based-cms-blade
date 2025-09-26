@extends('layouts.frontend')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Profile Information</h5>
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-sm btn-primary">Edit Profile</a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Full Name</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4">Username</dt>
                        <dd class="col-sm-8">{{ $user->username }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }} 
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">{{ $user->phone ?? 'Not Provided' }}</dd>

                        <dt class="col-sm-4">Company</dt>
                        <dd class="col-sm-8">{{ $user->company_name ?? '-' }}</dd>

                        <dt class="col-sm-4">Job Title</dt>
                        <dd class="col-sm-8">{{ $user->job_title ?? '-' }}</dd>

                        <dt class="col-sm-4">Country</dt>
                        <dd class="col-sm-8">{{ $user->country?->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Member Since</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('M d, Y') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Account Security</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('student.profile.edit') }}#password-section" 
                       class="btn btn-outline-danger btn-sm mb-2">Change Password</a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 fw-bold">Security Questions</h5>
                </div>
                <div class="card-body">
                    @php
                        $securityQuestions = $user->security_questions 
                            ? json_decode($user->security_questions, true) 
                            : [];
                    @endphp

                    @if(count($securityQuestions) > 0)
                        <dl class="row">
                            @foreach($securityQuestions as $index => $qa)
                                <dt class="col-sm-6">Q{{ $index+1 }}: {{ $qa['question'] }}</dt>
                                <dd class="col-sm-6">Answer: {{ $qa['answer'] }}</dd>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-muted">No security questions set.</p>
                    @endif

                    <a href="{{ route('student.profile.edit') }}#security-section" 
                       class="btn btn-outline-warning btn-sm">Update Security Questions</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
