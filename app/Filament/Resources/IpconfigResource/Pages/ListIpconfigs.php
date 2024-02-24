<?php

namespace App\Filament\Resources\IpconfigResource\Pages;

use App\Filament\Resources\IpconfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIpconfigs extends ListRecords
{
    protected static string $resource = IpconfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
