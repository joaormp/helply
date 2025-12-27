<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource\Pages;

use App\Filament\Tenant\Resources\KnowledgeBase\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
