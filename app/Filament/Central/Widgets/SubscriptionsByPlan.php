<?php

namespace App\Filament\Central\Widgets;

use App\Models\Central\Plan;
use Filament\Widgets\ChartWidget;

class SubscriptionsByPlan extends ChartWidget
{
    protected ?string $heading = 'Subscriptions by Plan';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $plans = Plan::withCount([
            'subscriptions' => function ($query) {
                $query->where('status', 'active');
            },
        ])->get();

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
                    'label' => 'Active Subscriptions',
                    'data' => $plans->pluck('subscriptions_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $plans->count()),
                    'borderColor' => 'rgba(255, 255, 255, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $plans->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected ?string $pollingInterval = '60s';

    public function getDescription(): ?string
    {
        return 'Distribution of active subscriptions across different plans';
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
