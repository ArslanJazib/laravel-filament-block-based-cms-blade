<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $siteSettings->meta_title ?? 'KANDOR - Transform Your Life' }}</title>

    {{-- Favicons --}}
    @if($siteSettings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    @endif
    @if($siteSettings->favicon_16x16)
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . $siteSettings->favicon_16x16) }}">
    @endif
    @if($siteSettings->favicon_32x32)
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . $siteSettings->favicon_32x32) }}">
    @endif
    @if($siteSettings->apple_touch_icon)
        <link rel="apple-touch-icon" href="{{ asset('storage/' . $siteSettings->apple_touch_icon) }}">
    @endif

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $siteSettings->meta_description }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">

    {{-- Global Styles --}}
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">

    {{-- Dynamic Block CSS --}}
    @stack('block-styles')

    {{-- Google Tag Manager --}}
    {!! $siteSettings->google_tag_manager !!}
</head>

<body>
<div class="wrapper">

    {{-- Navigation --}}
    <nav class="container">
        <div class="logo">
            @if($siteSettings->logo)
                <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="{{ $siteSettings->site_title }}">
            @else
                {{ $siteSettings->site_title ?? 'KANDOR' }}
            @endif
        </div>

        <ul class="menu">
            @foreach($siteSettings->header_menu ?? [] as $menuItem)
                <li class="menu-item">
                    <a href="{{ $menuItem['url'] }}">{{ $menuItem['label'] }}</a>
                    @if(!empty($menuItem['submenu']))
                        <ul class="submenu">
                            @foreach($menuItem['submenu'] as $submenu)
                                <li><a href="{{ $submenu['url'] }}">{{ $submenu['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        
    </nav>

    {{-- Dynamic Page Content (blocks) --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <ul>
            @foreach($siteSettings->footer_menu ?? [] as $menuItem)
                <li><a href="{{ $menuItem['url'] }}">{{ $menuItem['label'] }}</a></li>
            @endforeach
        </ul>
        <p>&copy; {{ date('Y') }} {{ $siteSettings->site_title ?? 'KANDOR' }}. All rights reserved.</p>
    </footer>
</div>

{{-- Global Scripts --}}
<script src=""></script>

{{-- Dynamic Block JS --}}
@stack('block-scripts')

</body>
</html>