@php
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
    $heading         = $data['heading'] ?? null;
    $subheading      = $data['subheading'] ?? null;
    $buttonText      = $data['button_text'] ?? null;
    $buttonLink      = $data['button_link'] ?? '#';

    $backgroundImage = null;
    if (!empty($data['background_image']) && isset($data['background_image'][0])) {
        $mediaId = $data['background_image'][0];
        $media = Media::find($mediaId);
        if ($media) {
            $backgroundImage = $media->getUrl(); // Spatie resolves full URL
        }
    }
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
