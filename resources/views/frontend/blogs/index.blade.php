@extends('layouts.frontend')

@section('title', 'Blogs')

@section('content')
@php
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
@endphp

<div class="container py-5">
    <h1 class="mb-4 fw-bold">Explore Our Blogs</h1>

    <!-- Filters -->
    <form method="GET" action="{{ route('blogs.index') }}" class="row g-3 align-items-center mb-4">
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <select name="tag" class="form-select">
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->slug }}" {{ request('tag') === $tag->slug ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" 
                   name="date" 
                   value="{{ request('date') }}" 
                   class="form-control">
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">
                Apply
            </button>
        </div>
    </form>

    <!-- Blog Grid -->
    <div class="row g-4">
        @forelse($blogs as $blog)
            @php
                // Default image
                $thumbnailUrl = asset('images/default-blog.jpg');

                // Resolve via Spatie Media Library if exists
                if ($blog->hasMedia('blog-featured')) {
                    $media = $blog->getFirstMedia('blog-featured');
                    if ($media) {
                        $thumbnailUrl = $media->getUrl();
                    }
                }
            @endphp

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img 
                        src="{{ $thumbnailUrl }}" 
                        alt="{{ $blog->title }}" 
                        class="card-img-top" 
                        style="object-fit: cover; height: 220px;"
                    >

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="text-decoration-none text-dark">
                                {{ $blog->title }}
                            </a>
                        </h5>

                        <p class="text-muted small mb-2">
                            {{ optional($blog->category)->name ?? 'Uncategorized' }} 
                            • {{ $blog->published_at?->format('M d, Y') }}
                        </p>

                        <p class="card-text text-truncate" style="max-height: 3rem;">
                            {{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 100) }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                            @if($blog->tags->isNotEmpty())
                                <span class="small text-muted">
                                    {{ $blog->tags->pluck('name')->take(1)->implode(', ') }}
                                    @if($blog->tags->count() > 1) +{{ $blog->tags->count() - 1 }} @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No blogs found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
