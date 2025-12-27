<?php

namespace App\Filament\Central\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.central.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Central\Widgets\StatsOverview::class,
            \App\Filament\Central\Widgets\TenantsChart::class,
            \App\Filament\Central\Widgets\RecentTenants::class,
            \App\Filament\Central\Widgets\SubscriptionsByPlan::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
