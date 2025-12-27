<?php

namespace App\Filament\Tenant\Resources\MailboxResource\Pages;

use App\Filament\Tenant\Resources\MailboxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailbox extends EditRecord
{
    protected static string $resource = MailboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
