<?php

namespace App\Filament\Tenant\Resources\CannedReplyResource\Pages;

use App\Filament\Tenant\Resources\CannedReplyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCannedReply extends CreateRecord
{
    protected static string $resource = CannedReplyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set current user as owner for private replies
        if (! $data['is_shared'] && ! isset($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        // Clear user_id for shared replies
        if ($data['is_shared']) {
            $data['user_id'] = null;
        }

        return $data;
    }
}
