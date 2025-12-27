<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\MailboxResource\Pages;
use App\Models\Tenant\Mailbox;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MailboxResource extends Resource
{
    protected static ?string $model = Mailbox::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Mailboxes';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Mailbox Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Mailbox Name')
                            ->placeholder('Support, Sales, etc.'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label('Email Address'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive mailboxes will not fetch emails'),
                    ])->columns(3),

                Forms\Components\Section::make('IMAP Configuration (Incoming)')
                    ->description('Configure IMAP settings to receive emails')
                    ->schema([
                        Forms\Components\TextInput::make('imap_host')
                            ->required()
                            ->maxLength(255)
                            ->label('IMAP Host')
                            ->placeholder('imap.gmail.com'),

                        Forms\Components\TextInput::make('imap_port')
                            ->required()
                            ->numeric()
                            ->default(993)
                            ->label('IMAP Port'),

                        Forms\Components\Select::make('imap_encryption')
                            ->options([
                                'ssl' => 'SSL',
                                'tls' => 'TLS',
                                'none' => 'None',
                            ])
                            ->default('ssl')
                            ->required()
                            ->label('Encryption'),

                        Forms\Components\TextInput::make('imap_username')
                            ->required()
                            ->maxLength(255)
                            ->label('Username')
                            ->helperText('Usually same as email address'),

                        Forms\Components\TextInput::make('imap_password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->label('Password')
                            ->revealable(),
                    ])->columns(2),

                Forms\Components\Section::make('SMTP Configuration (Outgoing)')
                    ->description('Configure SMTP settings to send emails')
                    ->schema([
                        Forms\Components\TextInput::make('smtp_host')
                            ->required()
                            ->maxLength(255)
                            ->label('SMTP Host')
                            ->placeholder('smtp.gmail.com'),

                        Forms\Components\TextInput::make('smtp_port')
                            ->required()
                            ->numeric()
                            ->default(587)
                            ->label('SMTP Port'),

                        Forms\Components\Select::make('smtp_encryption')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                                'none' => 'None',
                            ])
                            ->default('tls')
                            ->required()
                            ->label('Encryption'),

                        Forms\Components\TextInput::make('smtp_username')
                            ->required()
                            ->maxLength(255)
                            ->label('Username'),

                        Forms\Components\TextInput::make('smtp_password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->label('Password')
                            ->revealable(),
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

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

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

                Tables\Columns\TextColumn::make('last_fetched_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->label('Last Checked')
                    ->since(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active mailboxes')
                    ->falseLabel('Inactive mailboxes')
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
            'index' => Pages\ListMailboxes::route('/'),
            'create' => Pages\CreateMailbox::route('/create'),
            'edit' => Pages\EditMailbox::route('/{record}/edit'),
        ];
    }
}
