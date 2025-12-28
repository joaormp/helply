<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\SlaPolicyResource\Pages;
use App\Models\Tenant\SlaPolicy;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SlaPolicyResource extends Resource
{
    protected static ?string $model = SlaPolicy::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'SLA Policies';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Policy Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Policy Name')
                            ->placeholder('e.g., Standard Support, Premium Support')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->label('Description')
                            ->placeholder('Brief description of this SLA policy')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Response Times')
                    ->description('Set target response and resolution times in minutes')
                    ->schema([
                        Forms\Components\TextInput::make('first_response_time')
                            ->numeric()
                            ->suffix('minutes')
                            ->label('First Response Time')
                            ->placeholder('60')
                            ->helperText('Target time for first agent response'),

                        Forms\Components\TextInput::make('resolution_time')
                            ->numeric()
                            ->suffix('minutes')
                            ->label('Resolution Time')
                            ->placeholder('480')
                            ->helperText('Target time for ticket resolution'),
                    ])->columns(2),

                Forms\Components\Section::make('Conditions')
                    ->schema([
                        Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'normal' => 'Normal',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->native(false)
                            ->label('Apply to Priority')
                            ->helperText('This policy will apply to tickets with this priority'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active policies will be applied to tickets'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'normal' => 'info',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->formatStateUsing(fn (?string $state): string => $state ? ucfirst($state) : 'All'),

                Tables\Columns\TextColumn::make('first_response_time')
                    ->label('First Response')
                    ->sortable()
                    ->formatStateUsing(fn (?int $state): string => $state ? self::formatMinutes($state) : 'N/A'),

                Tables\Columns\TextColumn::make('resolution_time')
                    ->label('Resolution Time')
                    ->sortable()
                    ->formatStateUsing(fn (?int $state): string => $state ? self::formatMinutes($state) : 'N/A'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->label('Tickets')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'normal' => 'Normal',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->native(false),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active policies')
                    ->falseLabel('Inactive policies')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlaPolicies::route('/'),
            'create' => Pages\CreateSlaPolicy::route('/create'),
            'edit' => Pages\EditSlaPolicy::route('/{record}/edit'),
        ];
    }

    protected static function formatMinutes(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes.' min';
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes === 0) {
            return $hours.' '.($hours === 1 ? 'hour' : 'hours');
        }

        return $hours.'h '.$remainingMinutes.'m';
    }
}
