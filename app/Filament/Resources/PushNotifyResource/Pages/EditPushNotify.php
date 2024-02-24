<?php

namespace App\Filament\Resources\PushNotifyResource\Pages;

use App\Filament\Resources\PushNotifyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPushNotify extends EditRecord
{
    protected static string $resource = PushNotifyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
