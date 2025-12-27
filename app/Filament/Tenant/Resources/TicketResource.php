<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\TicketResource\Pages;
use App\Models\Tenant\Ticket;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Tickets';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Ticket Information')
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->maxLength(500)
                            ->label('Subject')
                            ->placeholder('Brief description of the issue')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->label('Description')
                            ->placeholder('Detailed description of the issue...')
                            ->helperText('Provide all relevant details about this ticket')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ]),

                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required()
                            ->label('Customer')
                            ->placeholder('Select or create a customer')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Name'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->label('Email'),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone'),
                                Forms\Components\TextInput::make('company')
                                    ->label('Company'),
                            ]),

                        Forms\Components\Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'pending' => 'Pending',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed',
                            ])
                            ->default('open')
                            ->required()
                            ->label('Status')
                            ->native(false),

                        Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->default('medium')
                            ->required()
                            ->label('Priority')
                            ->native(false),
                    ])->columns(3),

                Forms\Components\Section::make('Assignment')
                    ->schema([
                        Forms\Components\Select::make('assigned_to')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Assigned Agent')
                            ->placeholder('Assign to an agent'),

                        Forms\Components\Select::make('team_id')
                            ->relationship('team', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Team')
                            ->placeholder('Assign to a team'),

                        Forms\Components\Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->label('Tags')
                            ->placeholder('Add tags for categorization')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Tag Name'),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->label('Slug'),
                                Forms\Components\ColorPicker::make('color')
                                    ->required()
                                    ->label('Color'),
                            ]),
                    ])->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Select::make('mailbox_id')
                            ->relationship('mailbox', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Mailbox')
                            ->placeholder('Source mailbox'),

                        Forms\Components\Select::make('source')
                            ->options([
                                'email' => 'Email',
                                'web' => 'Web',
                                'api' => 'API',
                            ])
                            ->default('web')
                            ->required()
                            ->label('Source')
                            ->native(false),
                    ])->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->label('#'),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap()
                    ->weight('medium')
                    ->description(fn ($record) => $record->body ? strip_tags(substr($record->body, 0, 100)).'...' : null),

                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable()
                    ->label('Customer')
                    ->icon('heroicon-o-user')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'danger',
                        'pending' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'urgent' => 'danger',
                        'high' => 'warning',
                        'medium' => 'info',
                        'low' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->label('Tags')
                    ->toggleable()
                    ->limitList(3)
                    ->color('primary'),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->sortable()
                    ->placeholder('Unassigned')
                    ->icon('heroicon-o-user-circle')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('team.name')
                    ->label('Team')
                    ->sortable()
                    ->placeholder('No team')
                    ->badge()
                    ->toggleable()
                    ->color('info'),

                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'email' => 'warning',
                        'web' => 'success',
                        'api' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->description(fn ($record) => $record->created_at->format('M j, Y g:i A'))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'pending' => 'Pending',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ])
                    ->multiple()
                    ->label('Status'),

                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ])
                    ->multiple()
                    ->label('Priority'),

                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Assigned Agent'),

                Tables\Filters\SelectFilter::make('team_id')
                    ->relationship('team', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Team'),

                Tables\Filters\SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Tags'),

                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'email' => 'Email',
                        'web' => 'Web',
                        'api' => 'API',
                    ])
                    ->label('Source'),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
