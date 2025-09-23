@extends('layouts.frontend')

@section('title', $course->title . ' - Enrolled')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Left Content Area -->
        <div class="col-lg-9">
            <!-- Video Player -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-3" id="lesson-title">
                        {{ $currentLesson->title ?? $course->title }}
                    </h4>

                    @if($currentLesson && $currentLesson->video_url)
                        <div class="ratio ratio-16x9 mb-3">
                            <video id="lesson-video" class="w-100" controls>
                                <source src="{{ asset('storage/' . $currentLesson->video_url) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @else
                        <p class="text-muted">No video available for this lesson.</p>
                    @endif

                    <!-- Downloadable Resources -->
                    @if($currentLesson && $currentLesson->resources && count($currentLesson->resources))
                        <h6 class="fw-semibold">Resources</h6>
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($currentLesson->resources as $resource)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ basename($resource) }}
                                    <a href="{{ asset('storage/' . $resource) }}" 
                                       download 
                                       class="btn btn-sm btn-outline-primary">
                                       Download
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <h6 class="fw-semibold">Comments</h6>
                        <form method="POST" action="{{ route('courses.comment', [$course->id, $currentLesson->id]) }}">
                            @csrf
                            <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Add a comment..."></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                        </form>

                        <div class="mt-3">
                            @foreach($currentLesson->comments as $comment)
                                <div class="border p-2 rounded mb-2">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div class="mt-4">
                        <h6 class="fw-semibold">Rate this Course</h6>
                        <form method="POST" action="{{ route('courses.rate', $course->id) }}">
                            @csrf
                            <select name="rating" class="form-select w-25 mb-2">
                                <option value="">Select Rating</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Star</option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">Submit Rating</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar (Curriculum) -->
        <div class="col-lg-3">
            <div class="card shadow-sm sticky-top" style="top: 20px; max-height: 80vh; overflow-y: auto;">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Course Content</h5>
                    <div class="accordion" id="courseCurriculum">
                        @foreach($course->topics as $topic)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $topic->id }}">
                                    <button class="accordion-button collapsed" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $topic->id }}">
                                        {{ $topic->title }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $topic->id }}" class="accordion-collapse collapse" 
                                    data-bs-parent="#courseCurriculum">
                                    <div class="accordion-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach($topic->lessons as $lesson)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('courses.enrolled.show', [$course->id, $lesson->id]) }}" 
                                                       class="{{ $currentLesson && $currentLesson->id == $lesson->id ? 'fw-bold text-primary' : '' }}">
                                                        {{ $lesson->title }}
                                                    </a>
                                                    <small class="text-muted">
                                                        @if($lesson->duration < 60)
                                                            {{ $lesson->duration }} min
                                                        @else
                                                            {{ round($lesson->duration / 60, 1) }} hr
                                                        @endif
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection