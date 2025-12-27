<?php

namespace App\Filament\Tenant\Resources\SlaPolicyResource\Pages;

use App\Filament\Tenant\Resources\SlaPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlaPolicies extends ListRecords
{
    protected static string $resource = SlaPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
