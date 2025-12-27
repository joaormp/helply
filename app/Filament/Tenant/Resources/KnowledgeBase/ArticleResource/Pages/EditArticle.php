<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource\Pages;

use App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
