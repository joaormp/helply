<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase\CategoryResource\Pages;

use App\Filament\Tenant\Resources\KnowledgeBase\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
