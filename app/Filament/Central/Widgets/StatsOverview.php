<?php

namespace App\Filament\Central\Widgets;

use App\Models\Central\Subscription;
use App\Models\Central\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total tenants
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        $trialTenants = Tenant::where('status', 'trial')->count();

        // Subscription metrics
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $mrr = Subscription::where('status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price_monthly');

        // Growth (tenants created in last 30 days vs previous 30 days)
        $last30Days = Tenant::where('created_at', '>=', now()->subDays(30))->count();
        $previous30Days = Tenant::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $growthPercent = $previous30Days > 0 ? round((($last30Days - $previous30Days) / $previous30Days) * 100, 1) : 0;

        return [
            Stat::make('Total Tenants', $totalTenants)
                ->description("{$activeTenants} active, {$trialTenants} on trial")
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success')
                ->chart([7, 12, 15, 18, 20, 22, $totalTenants]),

            Stat::make('Active Subscriptions', $activeSubscriptions)
                ->description('Paying customers')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary')
                ->chart([10, 15, 18, 20, 22, 25, $activeSubscriptions]),

            Stat::make('Monthly Recurring Revenue', '$'.number_format($mrr, 2))
                ->description('Total MRR from active subscriptions')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([1000, 1500, 2000, 2500, 3000, 3500, $mrr]),

            Stat::make('Growth Rate', ($growthPercent >= 0 ? '+' : '').$growthPercent.'%')
                ->description('Last 30 days vs previous 30 days')
                ->descriptionIcon($growthPercent >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($growthPercent >= 0 ? 'success' : 'danger')
                ->chart(array_fill(0, 7, abs($growthPercent))),
        ];
    }

    protected ?string $pollingInterval = '30s';
}
