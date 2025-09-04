@extends('layouts.frontend')

@section('title', $page->title)

@section('content')
    @foreach($blocks as $block)
        
        {{-- Block-specific CSS --}}
        @push('block-styles')
            <link rel="stylesheet" href="{{ asset("css/blocks/{$block->block->slug}/{$block->block->slug}.css") }}">
        @endpush

        {{-- Block-specific JS --}}
        @push('block-scripts')
            <script src="{{ asset("js/blocks/{$block->block->slug}/{$block->block->slug}.js") }}"></script>
        @endpush

        {{-- Each PageBlock may have multiple content entries (JSON array) --}}
        @foreach($block->content as $contentItem)
            @includeIf(
                "frontend." . $block->block->view,
                [
                    'data'      => $contentItem['data'] ?? [],
                    'blockSlug' => $block->block->slug,
                ]
            )
        @endforeach

    @endforeach
@endsection