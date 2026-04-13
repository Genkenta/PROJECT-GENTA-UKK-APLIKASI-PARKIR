<?php

namespace App\Providers\Filament;

use Filament\{Panel, PanelProvider};
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\{EncryptCookies, AddQueuedCookiesToResponse};
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Filament\Http\Middleware\{
    Authenticate,
    AuthenticateSession,
    DisableBladeIconComponents,
    DispatchServingFilamentEvent
};
use App\Filament\Widgets\{LatestTransaksi, StatsOverview, TransaksiChart};

class OwnerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('owner')
            ->path('owner')
            ->colors(['primary' => Color::Amber])
            ->font('Nunito')
            ->brandName('SPARK ⚡')
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => new HtmlString('
                <style>
                    @font-face {
                        font-family: "Equinox";
                        src: url("/fonts/Equinox-Bold.woff") format("woff"),
                             url("/fonts/Equinox-Bold.otf") format("opentype");
                        font-weight: 700;
                    }
                    .fi-logo span, .fi-logo {
                        font-family: "Equinox", sans-serif !important;
                        color: #F5A623 !important;
                        letter-spacing: 2px !important;
                    }
                </style>
            '))
            ->discoverResources(in: app_path('Filament/Owner/Resources'), for: 'App\Filament\Owner\Resources')
            ->discoverPages(in: app_path('Filament/Owner/Pages'), for: 'App\Filament\Owner\Pages')
            ->discoverWidgets(in: app_path('Filament/Owner/Widgets'), for: 'App\Filament\Owner\Widgets')
            ->pages([
                \App\Filament\Owner\Pages\Dashboard::class,
                \App\Filament\Owner\Pages\RekapTransaksi::class,
                \App\Filament\Owner\Pages\RekapTransaksi::class,      
            ])
            ->widgets([
                AccountWidget::class,
                LatestTransaksi::class,
                StatsOverview::class,
                TransaksiChart::class,
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
            ->authMiddleware([Authenticate::class]);
    }
}
