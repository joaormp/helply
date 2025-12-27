<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Tenant\Team;
use Filament\Widgets\ChartWidget;

class TeamPerformance extends ChartWidget
{
    protected static ?string $heading = 'Team Performance';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $teams = Team::where('active', true)
            ->withCount([
                'tickets as solved_tickets' => function ($query) {
                    $query->where('status', 'solved')
                        ->where('created_at', '>=', now()->subDays(30));
                },
                'tickets as total_tickets' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(30));
                },
            ])
            ->get();

        $colors = [
            'rgba(59, 130, 246, 0.8)',   // Blue
            'rgba(139, 92, 246, 0.8)',   // Purple
            'rgba(236, 72, 153, 0.8)',   // Pink
            'rgba(249, 115, 22, 0.8)',   // Orange
            'rgba(34, 197, 94, 0.8)',    // Green
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Solved',
                    'data' => $teams->pluck('solved_tickets')->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Total',
                    'data' => $teams->pluck('total_tickets')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.8)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $teams->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected static ?string $pollingInterval = '60s';

    public function getDescription(): ?string
    {
        return 'Tickets solved vs total tickets by team (last 30 days)';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
