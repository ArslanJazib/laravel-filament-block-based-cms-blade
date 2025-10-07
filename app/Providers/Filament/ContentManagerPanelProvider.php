<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

// import only the resources you want for Content Manager
use App\Filament\Resources\PageResource;
use App\Filament\Resources\BlockResource;
use App\Filament\Resources\BlogCategoryResource;
use App\Filament\Resources\BlogResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\MediaResource;
use App\Filament\Resources\SiteSettingResource;
use App\Filament\Resources\TagResource;

class ContentManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('content-manager')
            ->path('content-manager')
            ->login()
            ->authGuard('content-manager')
            ->colors([
                'primary' => Color::Cyan,
            ])
            ->resources([
                PageResource::class,
                BlockResource::class,
                BlogResource::class,
                BlogCategoryResource::class,
                TagResource::class,
                MediaResource::class,
                SiteSettingResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                'role:content-manager',
            ]);
    }
}
