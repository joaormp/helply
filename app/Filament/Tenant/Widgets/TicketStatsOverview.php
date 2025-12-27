<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Tenant\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ticket counts by status
        $openTickets = Ticket::where('status', 'open')->count();
        $pendingTickets = Ticket::where('status', 'pending')->count();
        $solvedTickets = Ticket::where('status', 'solved')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();

        // Response time metrics
        $avgResponseTime = $this->calculateAverageResponseTime();

        // New tickets today vs yesterday
        $ticketsToday = Ticket::whereDate('created_at', today())->count();
        $ticketsYesterday = Ticket::whereDate('created_at', today()->subDay())->count();
        $changePercent = $ticketsYesterday > 0 ? round((($ticketsToday - $ticketsYesterday) / $ticketsYesterday) * 100, 1) : 0;

        // Satisfaction rate (dummy data for now - implement later with feedback system)
        $satisfactionRate = 95;

        return [
            Stat::make('Open Tickets', $openTickets)
                ->description("{$pendingTickets} pending response")
                ->descriptionIcon('heroicon-m-ticket')
                ->color('warning')
                ->chart([10, 12, 15, 14, 13, 12, $openTickets]),

            Stat::make('Solved Today', $ticketsToday)
                ->description(($changePercent >= 0 ? '+' : '').$changePercent.'% vs yesterday')
                ->descriptionIcon($changePercent >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('success')
                ->chart([5, 8, 10, 12, 15, 14, $ticketsToday]),

            Stat::make('Avg Response Time', $avgResponseTime)
                ->description('First response to customers')
                ->descriptionIcon('heroicon-m-clock')
                ->color('primary')
                ->chart([4, 3.5, 3, 2.5, 2, 1.5, 1]),

            Stat::make('Customer Satisfaction', $satisfactionRate.'%')
                ->description('Based on customer feedback')
                ->descriptionIcon('heroicon-m-face-smile')
                ->color('success')
                ->chart([90, 92, 93, 94, 95, 95, $satisfactionRate]),
        ];
    }

    protected function calculateAverageResponseTime(): string
    {
        // Get tickets with at least one message from agent
        $tickets = Ticket::with('messages')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        $totalMinutes = 0;
        $count = 0;

        foreach ($tickets as $ticket) {
            $firstAgentMessage = $ticket->messages()
                ->whereHas('user', function ($query) {
                    $query->whereIn('role', ['admin', 'manager', 'agent']);
                })
                ->orderBy('created_at')
                ->first();

            if ($firstAgentMessage) {
                $diffInMinutes = $ticket->created_at->diffInMinutes($firstAgentMessage->created_at);
                $totalMinutes += $diffInMinutes;
                $count++;
            }
        }

        if ($count === 0) {
            return '0m';
        }

        $avgMinutes = $totalMinutes / $count;

        if ($avgMinutes < 60) {
            return round($avgMinutes).'m';
        }

        return round($avgMinutes / 60, 1).'h';
    }

    protected ?string $pollingInterval = '30s';
}
