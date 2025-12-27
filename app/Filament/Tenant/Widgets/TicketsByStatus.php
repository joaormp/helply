<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Tenant\Ticket;
use Filament\Widgets\ChartWidget;

class TicketsByStatus extends ChartWidget
{
    protected static ?string $heading = 'Tickets by Status';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $statuses = [
            'open' => ['label' => 'Open', 'color' => 'rgba(249, 115, 22, 0.8)'],      // Orange
            'pending' => ['label' => 'Pending', 'color' => 'rgba(234, 179, 8, 0.8)'], // Yellow
            'on_hold' => ['label' => 'On Hold', 'color' => 'rgba(156, 163, 175, 0.8)'], // Gray
            'solved' => ['label' => 'Solved', 'color' => 'rgba(34, 197, 94, 0.8)'],    // Green
            'closed' => ['label' => 'Closed', 'color' => 'rgba(59, 130, 246, 0.8)'],   // Blue
        ];

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($statuses as $status => $config) {
            $count = Ticket::where('status', $status)->count();
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $config['label'];
                $colors[] = $config['color'];
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => 'rgba(255, 255, 255, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected static ?string $pollingInterval = '60s';

    public function getDescription(): ?string
    {
        return 'Current distribution of tickets across different statuses';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
