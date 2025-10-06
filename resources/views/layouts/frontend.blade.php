<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $siteSettings->meta_title ?? 'KANDOR - Transform Your Life' }}</title>

    {{-- Favicons --}}
    <link rel="icon" href="{{ $siteSettings->getFirstMediaUrl('favicons') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $siteSettings->getFirstMediaUrl('favicons_16x16') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $siteSettings->getFirstMediaUrl('favicons_32x32') }}">
    <link rel="apple-touch-icon" href="{{ $siteSettings->getFirstMediaUrl('apple_touch_icons') }}">

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $siteSettings->meta_description }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Video JS --}}
    <link href="https://vjs.zencdn.net/8.12.0/video-js.css" rel="stylesheet" />

    {{-- Global Styles --}}
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">

    {{-- Dynamic Block CSS --}}
    @stack('block-styles')

    {{-- Video JS --}}
    <script src="https://vjs.zencdn.net/8.12.0/video.min.js"></script>

    {{-- jQuery (latest stable) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Google Tag Manager --}}
    {!! $siteSettings->google_tag_manager !!}
</head>

<body>
<div class="wrapper">

    {{-- Navigation --}}
    <nav class="container d-flex justify-content-between align-items-center">
        {{-- Logo --}}
        <a href="{{ route('frontend.home') }}">
            <div class="logo">
                @if($siteSettings->getFirstMediaUrl('site_logos'))
                    <img src="{{ $siteSettings->getFirstMediaUrl('site_logos') }}" 
                        alt="{{ $siteSettings->site_title ?? 'KANDOR' }}">
                @else
                    {{ $siteSettings->site_title ?? 'KANDOR' }}
                @endif
            </div>
        </a>

        {{-- Menu --}}
        <ul class="menu d-flex align-items-center mb-0">
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

            {{-- Auth Links --}}
            @auth
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" 
                    href="#" id="userDropdown" role="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name ?? Auth::user()->username }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('student.profile.show') }}">
                                <i class="bi bi-person-lines-fill me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('student.enrolled.index') }}">
                                <i class="bi bi-bookshelf me-2"></i> My Learning
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li class="ms-3">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                </li>
                <li class="ms-2">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                </li>
            @endauth
        </ul>
        
    </nav>

    {{-- Dynamic Page Content (blocks) --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer>
        <ul class="footer-menu">
            @foreach($siteSettings->footer_menu ?? [] as $menuItem)
                <li><a href="{{ $menuItem['url'] }}">{{ $menuItem['label'] }}</a></li>
            @endforeach
        </ul>
        <p>&copy; {{ date('Y') }} {{ $siteSettings->site_title ?? 'KANDOR' }}. All rights reserved.</p>
    </footer>
</div>

{{-- Bootstrap 5 JS Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Global Scripts --}}
<script src=""></script>

{{-- Dynamic Block JS --}}
@stack('block-scripts')

</body>
</html>