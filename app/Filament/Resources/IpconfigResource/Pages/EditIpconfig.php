<?php

namespace App\Filament\Resources\IpconfigResource\Pages;

use App\Filament\Resources\IpconfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIpconfig extends EditRecord
{
    protected static string $resource = IpconfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
