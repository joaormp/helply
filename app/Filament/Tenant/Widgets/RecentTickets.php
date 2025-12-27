<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Tenant\Ticket;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTickets extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ticket::query()
                    ->with(['customer', 'agent', 'team'])
                    ->latest()
                    ->limit(10)
            )
            ->heading('Recent Tickets')
            ->description('Latest 10 ticket submissions')
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->label('Ticket #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Ticket number copied!')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->subject),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->icon('heroicon-m-user'),

                Tables\Columns\BadgeColumn::make('priority')
                    ->label('Priority')
                    ->colors([
                        'danger' => 'urgent',
                        'warning' => 'high',
                        'primary' => 'normal',
                        'success' => 'low',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'open',
                        'info' => 'pending',
                        'secondary' => 'on_hold',
                        'success' => 'solved',
                        'primary' => 'closed',
                    ]),

                Tables\Columns\TextColumn::make('agent.name')
                    ->label('Agent')
                    ->default('Unassigned')
                    ->icon('heroicon-m-user-circle'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Ticket $record): string => route('filament.tenant.resources.tickets.view', $record)),
            ]);
    }

    protected ?string $pollingInterval = '30s';
}
