<?php

namespace App\Filament\Tenant\Resources\SlaPolicyResource\Pages;

use App\Filament\Tenant\Resources\SlaPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlaPolicy extends EditRecord
{
    protected static string $resource = SlaPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
