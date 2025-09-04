@php
    $heading         = $data['heading'] ?? null;
    $subheading      = $data['subheading'] ?? null;
    $buttonText      = $data['button_text'] ?? null;
    $buttonLink      = $data['button_link'] ?? '#';
    $backgroundImage = !empty($data['background_image']) ? asset("storage/" . $data['background_image']) : null;
@endphp

<section class="hero" style="background-image: url('{{ $backgroundImage }}')" >
    <div class="content container">
        
        {{-- Heading --}}
        @if($heading)
            <h1>{{ $heading }}</h1>
        @endif

        {{-- Subheading --}}
        @if($subheading)
            <p>{{ $subheading }}</p>
        @endif

        {{-- Call to Action --}}
        @if($buttonText)
            <a href="{{ $buttonLink }}" class="btn">
                {{ $buttonText }}
            </a>
        @endif

    </div>
</section>
