@extends('layouts.frontend')

@section('title', $course->title)

@section('content')
@php
    use Spatie\MediaLibrary\MediaCollections\Models\Media;

    // Course Thumbnail
    $courseThumbnail = null;
    if (!empty($course->thumbnail)) {
        if (is_numeric($course->thumbnail)) {
            $media = Media::find($course->thumbnail);
            if ($media) $courseThumbnail = $media->getUrl();
        } else {
            $courseThumbnail = asset('storage/' . $course->thumbnail);
        }
    }

    // Course Intro Video
    $courseIntroVideo = null;
    if (!empty($course->intro_video)) {
        if (is_numeric($course->intro_video)) {
            $media = Media::find($course->intro_video);
            if ($media) $courseIntroVideo = $media->getUrl();
        } else {
            $courseIntroVideo = asset('storage/' . $course->intro_video);
        }
    }
@endphp

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
                @if($courseIntroVideo)
                    <video class="w-100 rounded shadow-sm" controls>
                        <source src="{{ $courseIntroVideo }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <p class="text-muted">No introduction video available.</p>
                @endif
            </div>

            <!-- Description -->
            <h4 class="fw-semibold mt-4">Description</h4>
            <p class="text-muted">{{ $course->description }}</p>

            <!-- Tabs Section -->
            <ul class="nav nav-tabs mt-5" id="courseTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="curriculum-tab" data-bs-toggle="tab"
                        data-bs-target="#curriculum" type="button" role="tab">
                        Curriculum
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ratings-tab" data-bs-toggle="tab"
                        data-bs-target="#ratings" type="button" role="tab">
                        Recent Ratings
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comments-tab" data-bs-toggle="tab"
                        data-bs-target="#comments" type="button" role="tab">
                        Recent Comments
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-4 bg-white shadow-sm" id="courseTabsContent">
                <!-- Curriculum Tab -->
                <div class="tab-pane fade show active" id="curriculum" role="tabpanel">
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

                <!-- Ratings Tab -->
                <div class="tab-pane fade" id="ratings" role="tabpanel">
                    @forelse($course->ratings as $rating)
                        <div class="border-bottom pb-2 mb-3">
                            <strong>{{ $rating->user->name ?? 'Anonymous' }}</strong>
                            <span class="text-warning">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi {{ $i <= $rating->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </span>
                            <p class="mb-1 text-muted">{{ $rating->feedback ?? 'No feedback given.' }}</p>
                            <small class="text-secondary">{{ $rating->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-muted">No ratings yet.</p>
                    @endforelse
                </div>

                <!-- Comments Tab -->
                <div class="tab-pane fade" id="comments" role="tabpanel">
                    @forelse($course->comments as $comment)
                        <div class="border-bottom pb-2 mb-3">
                            <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                            <p class="mb-1">{{ $comment->content }}</p>
                            <small class="text-secondary">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-muted">No comments yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                @if($courseThumbnail)
                    <img src="{{ $courseThumbnail }}" alt="{{ $course->title }}" class="card-img-top">
                @endif

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
                        <li><i class="bi bi-play-circle me-2"></i>
                            {{ $course->topics->sum(fn($t) => $t->lessons->count()) }} lessons
                        </li>
                        <li><i class="bi bi-clock me-2"></i>
                            Approx. {{ $course->topics->flatMap->lessons->sum('duration') ?? 'N/A' }}
                        </li>
                        <li><i class="bi bi-award me-2"></i> Certificate of completion</li>
                        <li><i class="bi bi-laptop me-2"></i> Access on mobile and desktop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
