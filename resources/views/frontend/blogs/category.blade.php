@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ $category->name }}</h1>

    <div class="row g-4">
        @forelse($blogs as $blog)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($blog->getFirstMediaUrl('blog-featured'))
                        <img src="{{ $blog->getFirstMediaUrl('blog-featured') }}" class="card-img-top" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p>{{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 100) }}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">No blogs found under this category.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
