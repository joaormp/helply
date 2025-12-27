<?php

namespace App\Filament\Central\Resources;

use App\Filament\Central\Resources\PlanResource\Pages;
use App\Models\Central\Plan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Plans';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Plan Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->label('Plan Name')
                            ->placeholder('Starter, Professional, Enterprise'),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->regex('/^[a-z0-9-]+$/')
                            ->helperText('URL-friendly identifier')
                            ->label('Slug'),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->label('Description')
                            ->placeholder('Perfect for small teams getting started')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active plans are visible to customers'),

                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order')
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('price_monthly')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->label('Monthly Price')
                            ->placeholder('29.00')
                            ->step(0.01),

                        Forms\Components\TextInput::make('price_yearly')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->label('Yearly Price')
                            ->placeholder('290.00')
                            ->helperText('Usually ~17% discount')
                            ->step(0.01),

                        Forms\Components\TextInput::make('stripe_monthly_price_id')
                            ->maxLength(255)
                            ->label('Stripe Monthly Price ID')
                            ->placeholder('price_xxxxxxxxxxxxx')
                            ->helperText('From Stripe Dashboard'),

                        Forms\Components\TextInput::make('stripe_yearly_price_id')
                            ->maxLength(255)
                            ->label('Stripe Yearly Price ID')
                            ->placeholder('price_xxxxxxxxxxxxx')
                            ->helperText('From Stripe Dashboard'),
                    ])->columns(2),

                Forms\Components\Section::make('Features')
                    ->schema([
                        Forms\Components\TagsInput::make('features')
                            ->label('Plan Features')
                            ->placeholder('Add feature (press Enter)')
                            ->helperText('List of features included in this plan')
                            ->suggestions([
                                'Unlimited tickets',
                                'Email support',
                                'Knowledge base',
                                '5 team members',
                                '10 team members',
                                'Unlimited team members',
                                'Priority support',
                                'Custom branding',
                                'API access',
                                'Advanced reporting',
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Limits')
                    ->schema([
                        Forms\Components\KeyValue::make('limits')
                            ->label('Plan Limits')
                            ->helperText('Define usage limits for this plan')
                            ->keyLabel('Limit Type')
                            ->valueLabel('Value')
                            ->addActionLabel('Add Limit')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->description),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price_monthly')
                    ->label('Monthly')
                    ->money('USD')
                    ->sortable()
                    ->color('success'),

                Tables\Columns\TextColumn::make('price_yearly')
                    ->label('Yearly')
                    ->money('USD')
                    ->sortable()
                    ->color('info')
                    ->description(fn ($record) => $record->price_monthly > 0 ? number_format((1 - ($record->price_yearly / ($record->price_monthly * 12))) * 100, 0).'% savings' : null),

                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->counts('subscriptions')
                    ->label('Subscriptions')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active plans')
                    ->falseLabel('Inactive plans')
                    ->native(false),
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
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'view' => Pages\ViewPlan::route('/{record}'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
