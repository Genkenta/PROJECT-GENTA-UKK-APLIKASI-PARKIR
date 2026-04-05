<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\LatestTransaksi;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TransaksiChart;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PetugasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('petugas')
            ->path('petugas')
            //->authGuard('web')
            //->middleware([
                //'auth',
                //'role:petugas',
            //])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->font('Nunito')
            ->brandName('SPARK ⚡')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn() => new HtmlString('
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
    ')
            )
            ->discoverResources(in: app_path('Filament/Petugas/Resources'), for: 'App\Filament\Petugas\Resources')
            ->discoverPages(in: app_path('Filament/Petugas/Pages'), for: 'App\Filament\Petugas\Pages')
            ->pages([
                \App\Filament\Petugas\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Petugas/Widgets'), for: 'App\Filament\Petugas\Widgets')
            ->widgets([
                AccountWidget::class,
                LatestTransaksi::class,
                StatsOverview::class,
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
            ]);
    }
}
