@extends('layouts.frontend')

@section('title', 'Courses')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold">Browse Courses</h1>

    <!-- Filters -->
    <form method="GET" action="{{ route('courses.index') }}" class="row g-3 align-items-center mb-4">
        <div class="col-md-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   class="form-control" 
                   placeholder="Search courses...">
        </div>

        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach(App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Apply Filters
            </button>
        </div>
    </form>

    <!-- Course Grid -->
    <div class="row g-4">
        @forelse($courses as $course)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                         class="card-img-top" 
                         alt="{{ $course->title }}">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">
                            <a href="{{ route('courses.show', $course->slug) }}" class="text-decoration-none text-dark">
                                {{ $course->title }}
                            </a>
                        </h5>

                        <p class="text-muted small mb-2">
                            By {{ $course->instructor->name ?? 'Unknown' }}
                        </p>

                        <p class="card-text text-truncate" style="max-height: 3rem;">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">${{ number_format($course->price, 2) }}</span>
                            <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline-primary btn-sm">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No courses found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $courses->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
