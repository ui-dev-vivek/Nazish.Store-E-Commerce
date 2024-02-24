<?php

namespace App\Filament\Resources\PushNotifyResource\Pages;

use App\Filament\Resources\PushNotifyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPushNotifies extends ListRecords
{
    protected static string $resource = PushNotifyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
