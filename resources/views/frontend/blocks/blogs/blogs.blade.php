@php
    use App\Models\Blog;

    // Default limit from block config or 3
    $limit = $data['limit'] ?? 3;

    $blogs = Blog::with(['author', 'category'])
        ->where('status', 'published')
        ->orderByDesc('published_at')
        ->take($limit)
        ->get();
@endphp

<section class="blog-section container py-5">
    <div class="section-header mb-4 text-center">
        <h2>{{ $data['heading'] ?? 'Latest Blogs' }}</h2>
        <p class="text-muted">{{ $data['subheading'] ?? 'Read our latest articles and insights' }}</p>
    </div>

    <div class="row g-4">
        @foreach($blogs as $blog)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($blog->getFirstMediaUrl('blog-featured'))
                        <img src="{{ $blog->getFirstMediaUrl('blog-featured') }}" class="card-img-top" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="text-muted mb-2">
                            {{ optional($blog->category)->name ?? 'Uncategorized' }}
                            • {{ $blog->published_at?->format('M d, Y') }}
                        </p>
                        <p class="card-text">{{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 100) }}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="btn btn-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('blogs.index') }}" class="btn btn-outline-primary">Load More Blogs</a>
    </div>
</section>