<?php

namespace App\Filament\Tenant\Resources\KnowledgeBase\CategoryResource\Pages;

use App\Filament\Tenant\Resources\KnowledgeBase\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
