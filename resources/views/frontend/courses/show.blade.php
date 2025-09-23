@extends('layouts.frontend')

@section('title', $course->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Course Header -->
            <h1 class="fw-bold mb-3">{{ $course->title }}</h1>

            <p class="text-muted mb-2">
                By <strong>{{ $course->instructor->name ?? 'Unknown' }}</strong>
                | Category: {{ $course->category->name ?? 'Uncategorized' }}
            </p>

            <div class="mb-4">
                @if($course->intro_video)
                    <video class="w-100 rounded shadow-sm" controls>
                        <source src="{{ asset('storage/' . $course->intro_video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <p class="text-muted">No introduction video available.</p>
                @endif
            </div>

            <!-- Description -->
            <h4 class="fw-semibold mt-4">Description</h4>
            <p class="text-muted">{{ $course->description }}</p>

            <!-- Curriculum -->
            <h4 class="fw-semibold mt-5">Course Curriculum</h4>
            @forelse($course->topics as $topic)
                <div class="mb-3">
                    <h5 class="fw-bold">{{ $topic->title }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($topic->lessons as $lesson)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $lesson->title }}</span>
                                <small class="text-muted">
                                    @if($lesson->duration)
                                        @if($lesson->duration < 60)
                                            {{ $lesson->duration }} min
                                        @else
                                            {{ round($lesson->duration / 60, 1) }} hr
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-muted">No curriculum available for this course.</p>
            @endforelse
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                     class="card-img-top" alt="{{ $course->title }}">
                
                <div class="card-body">
                    <h3 class="fw-bold text-primary mb-3">
                        ${{ number_format($course->price, 2) }}
                    </h3>

                    <!-- Enroll Button -->
                    @auth
                        <form method="POST" action="#">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Enroll Now
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">
                            Login to Enroll
                        </a>
                    @endauth

                    <!-- Course Highlights -->
                    <ul class="list-unstyled">
                        <li><i class="bi bi-play-circle me-2"></i> {{ $course->topics->sum(fn($t) => $t->lessons->count()) }} lessons</li>
                        <li><i class="bi bi-clock me-2"></i> Approx. {{ $course->topics->flatMap->lessons->sum('duration') ?? 'N/A' }}</li>
                        <li><i class="bi bi-award me-2"></i> Certificate of completion</li>
                        <li><i class="bi bi-laptop me-2"></i> Access on mobile and desktop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
