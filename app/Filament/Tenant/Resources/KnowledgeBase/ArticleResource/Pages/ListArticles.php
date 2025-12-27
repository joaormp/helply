<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource\Pages;

use App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
