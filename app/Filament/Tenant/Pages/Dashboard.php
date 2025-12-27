<?php

namespace App\Filament\Tenant\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

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
