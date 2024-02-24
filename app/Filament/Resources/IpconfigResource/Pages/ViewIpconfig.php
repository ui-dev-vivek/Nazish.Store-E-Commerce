<?php

namespace App\Filament\Resources\IpconfigResource\Pages;

use App\Filament\Resources\IpconfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIpconfig extends ViewRecord
{
    protected static string $resource = IpconfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
