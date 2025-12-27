<?php

namespace App\Filament\Central\Resources;

use App\Filament\Central\Resources\SubscriptionResource\Pages;
use App\Models\Central\Subscription;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Subscriptions';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Subscription Information')
                    ->schema([
                        Forms\Components\Select::make('tenant_id')
                            ->relationship('tenant', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Tenant')
                            ->placeholder('Select tenant'),

                        Forms\Components\Select::make('plan_id')
                            ->relationship('plan', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Plan')
                            ->placeholder('Select plan'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'trialing' => 'Trialing',
                                'past_due' => 'Past Due',
                                'canceled' => 'Canceled',
                                'unpaid' => 'Unpaid',
                            ])
                            ->default('trialing')
                            ->required()
                            ->label('Status')
                            ->native(false),

                        Forms\Components\Select::make('billing_cycle')
                            ->options([
                                'monthly' => 'Monthly',
                                'yearly' => 'Yearly',
                            ])
                            ->default('monthly')
                            ->required()
                            ->label('Billing Cycle')
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Stripe Integration')
                    ->schema([
                        Forms\Components\TextInput::make('stripe_subscription_id')
                            ->maxLength(255)
                            ->label('Stripe Subscription ID')
                            ->placeholder('sub_xxxxxxxxxxxxx')
                            ->helperText('From Stripe Dashboard')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Forms\Components\Section::make('Billing Dates')
                    ->schema([
                        Forms\Components\DateTimePicker::make('trial_ends_at')
                            ->label('Trial Ends At')
                            ->helperText('Leave empty if not on trial')
                            ->native(false),

                        Forms\Components\DateTimePicker::make('current_period_start')
                            ->label('Current Period Start')
                            ->required()
                            ->native(false),

                        Forms\Components\DateTimePicker::make('current_period_end')
                            ->label('Current Period End')
                            ->required()
                            ->native(false),

                        Forms\Components\DateTimePicker::make('cancelled_at')
                            ->label('Cancelled At')
                            ->helperText('Leave empty if subscription is active')
                            ->native(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->tenant->email),

                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'trialing' => 'info',
                        'past_due' => 'warning',
                        'canceled' => 'danger',
                        'unpaid' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),

                Tables\Columns\TextColumn::make('billing_cycle')
                    ->label('Billing')
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('current_period_end')
                    ->label('Renews')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->description(fn ($record) => $record->current_period_end->format('M j, Y')),

                Tables\Columns\TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('No trial')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('cancelled_at')
                    ->label('Cancelled')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('Active')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'trialing' => 'Trialing',
                        'past_due' => 'Past Due',
                        'canceled' => 'Canceled',
                        'unpaid' => 'Unpaid',
                    ])
                    ->multiple()
                    ->label('Status'),

                Tables\Filters\SelectFilter::make('plan_id')
                    ->label('Plan')
                    ->relationship('plan', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('billing_cycle')
                    ->options([
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->label('Billing Cycle'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'view' => Pages\ViewSubscription::route('/{record}'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
