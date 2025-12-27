<?php

namespace App\Filament\Central\Widgets;

use App\Models\Central\Tenant;
use Filament\Widgets\ChartWidget;

class TenantsChart extends ChartWidget
{
    protected static ?string $heading = 'Tenant Growth';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get tenant creation data for last 12 months
        $data = collect(range(11, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);

            return [
                'month' => $date->format('M Y'),
                'tenants' => Tenant::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'New Tenants',
                    'data' => $data->pluck('tenants')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected static ?string $pollingInterval = '60s';

    public function getDescription(): ?string
    {
        return 'New tenant signups over the last 12 months';
    }
}
