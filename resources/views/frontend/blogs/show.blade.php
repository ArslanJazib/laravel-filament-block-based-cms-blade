@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1>{{ $blog->title }}</h1>
            <p class="text-muted">
                {{ optional($blog->category)->name ?? 'Uncategorized' }} •
                {{ $blog->published_at?->format('F d, Y') }} •
                by {{ $blog->author->name ?? 'Admin' }}
            </p>

            @if($blog->getFirstMediaUrl('blog-featured'))
                <img src="{{ $blog->getFirstMediaUrl('blog-featured') }}" class="img-fluid mb-4" alt="{{ $blog->title }}">
            @endif

            <div class="content">
                {!! $blog->content !!}
            </div>

            {{-- Tags --}}
            @if($blog->tags->count())
                <div class="mt-4">
                    <h6>Tags:</h6>
                    @foreach($blog->tags as $tag)
                        <a href="{{ route('blogs.index', ['tag' => $tag->slug]) }}" class="badge bg-light text-dark border">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Related Blogs --}}
    @if($relatedBlogs->count())
        <div class="mt-5">
            <h3>Related Blogs</h3>
            <div class="row g-4 mt-3">
                @foreach($relatedBlogs as $related)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if($related->getFirstMediaUrl('blog-featured'))
                                <img src="{{ $related->getFirstMediaUrl('blog-featured') }}" class="card-img-top" alt="{{ $related->title }}">
                            @endif
                            <div class="card-body">
                                <h5>{{ $related->title }}</h5>
                                <a href="{{ route('blogs.show', $related->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
