<?php

namespace App\Filament\Tenant\Resources\CannedReplyResource\Pages;

use App\Filament\Tenant\Resources\CannedReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCannedReplies extends ListRecords
{
    protected static string $resource = CannedReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
