<?php

namespace App\Filament\Resources\PushNotifyResource\Pages;

use App\Filament\Resources\PushNotifyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPushNotify extends ViewRecord
{
    protected static string $resource = PushNotifyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
