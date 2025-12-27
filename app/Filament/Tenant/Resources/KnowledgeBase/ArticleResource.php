<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase;

use App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource\Pages;
use App\Models\Tenant\KnowledgeBase\Article;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'KB Articles';

    protected static ?int $navigationSort = 11;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Article Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(500)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->label('Article Title')
                            ->placeholder('How to reset your password')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(500)
                            ->unique(ignoreRecord: true)
                            ->regex('/^[a-z0-9-]+$/')
                            ->helperText('Auto-generated from title, used in URLs')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('excerpt')
                            ->maxLength(65535)
                            ->rows(3)
                            ->label('Excerpt')
                            ->placeholder('Brief summary shown in article listings')
                            ->helperText('Optional: If empty, will be auto-generated from body')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->label('Article Body')
                            ->placeholder('Write your knowledge base article here...')
                            ->helperText('Use formatting to make content easy to read')
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
                                'table',
                            ]),
                    ]),

                Forms\Components\Section::make('Article Settings')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Category')
                            ->placeholder('Select a category')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Category Name'),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->label('Slug'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description'),
                            ]),

                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->required()
                            ->label('Author'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(false)
                            ->helperText('Make article visible to customers')
                            ->live(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->helperText('Leave empty to auto-set on publish')
                            ->visible(fn (Forms\Get $get) => $get('is_published')),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50)
                    ->description(fn ($record) => $record->excerpt ? Str::limit($record->excerpt, 100) : null),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Uncategorized')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->badge()
                    ->color('warning')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->description(fn ($record) => $record->published_at?->format('M j, Y g:i A'))
                    ->placeholder('Not published')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published Status')
                    ->trueLabel('Published articles')
                    ->falseLabel('Draft articles')
                    ->native(false),

                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
