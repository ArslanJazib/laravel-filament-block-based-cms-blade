@extends('layouts.frontend')

@section('title', 'My Courses')

@section('content')
@php
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
@endphp

<div class="container py-5">
    <h2 class="fw-bold mb-4">My Learning</h2>

    @if($courses->count())
        <!-- Results count -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <small class="text-muted">
                Showing {{ $courses->firstItem() }}–{{ $courses->lastItem() }} of {{ $courses->total() }} courses
            </small>
            {{ $courses->links() }}
        </div>

        <div class="row g-4">
            @foreach($courses as $course)
                @php
                    // Resolve course image from Spatie Media Library
                    $thumbnailUrl = null;
                    if (!empty($course->thumbnail) && is_numeric($course->thumbnail)) {
                        $media = Media::find($course->thumbnail);
                        if ($media) {
                            $thumbnailUrl = $media->getUrl();
                        }
                    }

                    // Fallback image
                    if (!$thumbnailUrl) {
                        $thumbnailUrl = asset('images/course-placeholder.jpg');
                    }
                @endphp

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Thumbnail -->
                        <img src="{{ $thumbnailUrl }}" 
                             class="card-img-top" 
                             alt="{{ $course->title }}">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">{{ $course->title }}</h5>
                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            <a href="{{ route('courses.show', $course->slug) }}" 
                               class="btn btn-primary btn-sm mt-3">
                                Continue Learning
                            </a>
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <small class="text-muted">{{ $course->lessons_count }} lessons</small>
                            <small class="text-muted">{{ $course->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $courses->links() }}
        </div>
    @else
        <div class="alert alert-info">
            You are not enrolled in any courses yet.
        </div>
    @endif
</div>
@endsection
