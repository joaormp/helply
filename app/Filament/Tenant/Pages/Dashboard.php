<?php

namespace App\Filament\Tenant\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament.tenant.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Tenant\Widgets\TicketStatsOverview::class,
            \App\Filament\Tenant\Widgets\TicketsByStatus::class,
            \App\Filament\Tenant\Widgets\RecentTickets::class,
            \App\Filament\Tenant\Widgets\TeamPerformance::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
