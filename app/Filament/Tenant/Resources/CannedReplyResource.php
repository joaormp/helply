<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Tenant\Resources\CannedReplyResource\Pages;
use App\Models\Tenant\CannedReply;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CannedReplyResource extends Resource
{
    protected static ?string $model = CannedReply::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Canned Replies';

    protected static \UnitEnum|string|null $navigationGroup = 'Knowledge Base';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Canned Reply Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Reply Name')
                            ->placeholder('e.g., Welcome Message, Password Reset Instructions')
                            ->helperText('A descriptive name to identify this canned reply'),

                        Forms\Components\TextInput::make('subject')
                            ->maxLength(500)
                            ->label('Email Subject (Optional)')
                            ->placeholder('Subject line when used in email replies')
                            ->helperText('Leave blank to use the ticket subject'),

                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->label('Reply Content')
                            ->placeholder('Type your canned reply content here...')
                            ->helperText('Use {{customer_name}}, {{ticket_number}}, {{agent_name}} as placeholders')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_shared')
                            ->label('Shared Reply')
                            ->default(true)
                            ->helperText('Shared replies are available to all team members. Uncheck to make this private to you.'),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Owner')
                            ->helperText('For private replies, specify the owner')
                            ->visible(fn (Forms\Get $get) => ! $get('is_shared')),
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
                    ->weight('bold')
                    ->description(fn (CannedReply $record): ?string => $record->subject),

                Tables\Columns\TextColumn::make('body')
                    ->searchable()
                    ->limit(80)
                    ->html()
                    ->label('Preview'),

                Tables\Columns\IconColumn::make('is_shared')
                    ->boolean()
                    ->label('Shared')
                    ->sortable()
                    ->tooltip(fn (CannedReply $record): string => $record->is_shared ? 'Available to all agents' : 'Private reply'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->default('All Users')
                    ->formatStateUsing(fn (?string $state): string => $state ?? 'All Users'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_shared')
                    ->label('Visibility')
                    ->trueLabel('Shared replies')
                    ->falseLabel('Private replies')
                    ->native(false),

                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->label('Owner'),
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
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCannedReplies::route('/'),
            'create' => Pages\CreateCannedReply::route('/create'),
            'view' => Pages\ViewCannedReply::route('/{record}'),
            'edit' => Pages\EditCannedReply::route('/{record}/edit'),
        ];
    }
}
