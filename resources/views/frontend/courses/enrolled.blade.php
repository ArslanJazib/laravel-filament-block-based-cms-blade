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
                        <div class="mb-3 w-100">
                            <video
                                id="lesson-video"
                                class="video-js vjs-big-play-centered"
                                controls
                                preload="auto"
                                width="100%"
                                height="360"
                                data-setup="{}"
                            >
                                <source src="{{ route('video.stream', ['filename' => basename($currentLesson->video_url)]) }}" type="video/mp4">
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
                        <form method="POST" action="{{ route('student.enrolled.comment', [$course->id, $currentLesson->id]) }}">
                            @csrf
                            <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Add a comment..."></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
                        </form>

                        <div class="mt-3">
                            @forelse($recentComments as $comment)
                                <div class="border p-2 rounded mb-2">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p class="mb-0">{{ $comment->content }}</p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <p class="text-muted">No comments yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rating Section -->
                    <div class="mt-4">
                        <h6 class="fw-semibold">Rate this Course</h6>
                        <form method="POST" action="{{ route('student.enrolled.rate', $course->id) }}">
                            @csrf
                            <select name="rating" class="form-select w-25 mb-2">
                                <option value="">Select Rating</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }} Star</option>
                                @endfor
                            </select>

                            <div class="mb-2">
                                <label for="feedback">Feedback</label>
                                <textarea name="feedback" id="feedback" class="form-control" rows="3" placeholder="Write your feedback here..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-sm btn-success">Submit Rating</button>
                        </form>

                        <!-- Recent Ratings -->
                        <div class="mt-3">
                            <h6 class="fw-semibold">Recent Ratings</h6>
                            @forelse($recentRatings as $rating)
                                <div class="border p-2 rounded mb-2">
                                    <strong>{{ $rating->user->name }}</strong> 
                                    rated <span class="text-warning">{{ $rating->rating }} ★</span>
                                    <p class="mb-0">{{ $rating->feedback ?? 'No feedback given.' }}</p>
                                </div>
                            @empty
                                <p class="text-muted">No ratings yet.</p>
                            @endforelse
                        </div>
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
                                                    <a href="{{ route('student.enrolled.lesson', [$course->id, $lesson->id]) }}" 
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

@push('block-scripts')
<script>
$(document).ready(function () {
    var player = videojs('lesson-video');
    var lastSent = 0;    // throttle updates (1 sec granularity)

    // To Start from left off point
    @if($progress && $progress->current_second)
        player.ready(function () {
            player.currentTime({{ $progress->current_second }});
        });
    @endif

    // Track progress
    player.on('timeupdate', function () {
        var current = Math.floor(player.currentTime());
        var total   = Math.floor(player.duration());

        // Only send once per second
        if (total > 0 && current !== lastSent) {
            lastSent = current;

            $.ajax({
                url: "{{ route('student.enrolled.progress.update', [$course->id, $currentLesson->id]) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    current_second: current,
                    total_seconds: total,
                    progress_percent: Math.round((current / total) * 100)
                }
            });
        }
    });

    // Mark as completed when finished
    player.on('ended', function () {
        $.ajax({
            url: "{{ route('student.enrolled.progress.update', [$course->id, $currentLesson->id]) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                completed: true,
                progress_percent: 100
            }
        });
    });
});
</script>
@endpush