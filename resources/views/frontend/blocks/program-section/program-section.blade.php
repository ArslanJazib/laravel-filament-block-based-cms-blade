@php
    use App\Models\Category;

    $raw = $data ?? ($content ?? ($block->content ?? []));

    $payload = [];

    if (is_array($raw)) {
        if (isset($raw[0]) && is_array($raw[0]) && array_key_exists('type', $raw[0])) {
            foreach ($raw as $item) {
                if (($item['type'] ?? '') === 'program-section') {
                    $payload = $item['data'] ?? [];
                    break;
                }
            }
            if (empty($payload) && isset($raw[0]['data'])) {
                $payload = $raw[0]['data'] ?? [];
            }
        } elseif (array_key_exists('type', $raw) && array_key_exists('data', $raw)) {
            $payload = $raw['data'] ?? [];
        } else {
            $payload = $raw;
        }
    }

    $programs = $payload['programs'] ?? [];

    $categories = Category::orderBy('id')->get();
    $classMap = $categories->pluck('slug')->toArray();

    $resolveImage = function ($img) use ($blockSlug) {
        // If $img is empty, return null
        if (empty($img)) {
            return null;
        }

        // If $img is an array, get first element safely
        $mediaId = isset($img[0]) ? $img[0] : (is_numeric($img) ? $img : null);

        if (empty($mediaId)) {
            return null;
        }

        // Try fetching Spatie Media by ID
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
        if ($media) {
            return $media->getUrl();
        }

        return null; // Fallback if not found
    };

@endphp

<section id="programs" class="container">
    @if(is_array($programs) && count($programs))
        @foreach($programs as $i => $program)
            @php
                $group = $classMap[$i] ?? 'program';
                $title = $program['title'] ?? null;
                $description = $program['description'] ?? null;
                $courses = $program['courses'] ?? [];
                $btnText = $program['button_text'] ?? null;
                $btnLink = $program['button_link'] ?? '#signup';
                $image = $resolveImage($program['image'] ?? null);
            @endphp

            <div class="program-row">
                <div class="text">
                    @if($title)
                        <h2>{{ $title }}</h2>
                    @endif

                    @if($description)
                        <p>{{ $description }}</p>
                    @endif

                    @if(is_array($courses) && count($courses))
                        <div class="program-cards {{ $group }}-cards">
                            @foreach($courses as $course)
                                @php
                                    $courseTitle = is_array($course) ? ($course['title'] ?? '') : (string) $course;
                                @endphp
                                @if($courseTitle !== '')
                                    <div class="card">{{ $courseTitle }}</div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if($btnText)
                        <a href="{{ $btnLink ?? '#signup' }}" class="btn {{ $group }}-btn"> {{ $btnText }} </a>
                    @endif
                </div>

                <div class="media">
                    @if($image)
                        <img src="{{ $image }}" alt="{{ $title ?? 'Program' }}">
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>No programs configured yet.</p>
    @endif
</section>

