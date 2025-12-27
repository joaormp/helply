<?php

namespace App\Filament\Tenant\Resources\CannedReplyResource\Pages;

use App\Filament\Tenant\Resources\CannedReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCannedReply extends ViewRecord
{
    protected static string $resource = CannedReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
