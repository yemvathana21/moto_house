<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RecentOrders;
use App\Filament\Widgets\LowStockAlerts;
use App\Models\Setting;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_START,
            function () {
                $theme = Setting::getValue('theme', 'light');
                $primary = Setting::getValue('primary_color', '#ea580c');
                $blur = Setting::getValue('glassmorphism_blur', '12');
                $opacity = Setting::getValue('glassmorphism_opacity', '0.15');
                $bgColor = Setting::getValue('background_color', '');

                $css = '';

                if ($bgColor) {
                    $css .= "body { background-color: {$bgColor} !important; }";
                }

                if ($theme === 'glassmorphism') {
                    $css .= "
                        .fi-sidebar {
                            background: rgba(255,255,255,{$opacity}) !important;
                            backdrop-filter: blur({$blur}px) !important;
                            -webkit-backdrop-filter: blur({$blur}px) !important;
                            border-right: 1px solid rgba(255,255,255,0.1) !important;
                        }
                        .fi-main, .fi-topbar {
                            background: transparent !important;
                        }
                        .fi-card, .fi-section, .fi-widget-item {
                            background: rgba(255,255,255,{$opacity}) !important;
                            backdrop-filter: blur({$blur}px) !important;
                            -webkit-backdrop-filter: blur({$blur}px) !important;
                            border: 1px solid rgba(255,255,255,0.1) !important;
                            box-shadow: 0 8px 32px rgba(0,0,0,0.1) !important;
                        }
                        .fi-input-wrp {
                            background: rgba(255,255,255,0.1) !important;
                            backdrop-filter: blur(4px) !important;
                        }
                    ";
                } elseif ($theme === 'dark') {
                    $css .= "
                        :root { --color-gray-50: #111827; --color-gray-100: #1f2937; }
                        .fi-sidebar, .fi-main { background: #111827 !important; }
                    ";
                } elseif ($theme === 'minimal') {
                    $css .= "
                        .fi-sidebar { width: 4rem !important; }
                        .fi-sidebar-nav { padding: 0.5rem !important; }
                        .fi-sidebar-group-label { display: none !important; }
                    ";
                }

                if ($primary) {
                    $css .= ":root { --primary-500: {$primary}; --primary-600: {$primary}; }";
                }

                return "<style>{$css}</style>";
            }
        );
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('admin')
            ->brandName('Moto House')
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                StatsOverview::class,
                RevenueChart::class,
                RecentOrders::class,
                LowStockAlerts::class,
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
