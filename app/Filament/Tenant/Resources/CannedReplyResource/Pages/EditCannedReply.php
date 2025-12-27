<?php

namespace App\Filament\Tenant\Resources\CannedReplyResource\Pages;

use App\Filament\Tenant\Resources\CannedReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCannedReply extends EditRecord
{
    protected static string $resource = CannedReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Clear user_id for shared replies
        if ($data['is_shared']) {
            $data['user_id'] = null;
        }

        return $data;
    }
}
