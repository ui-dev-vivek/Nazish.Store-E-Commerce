<?php

namespace App\Filament\Resources\WidgetResource\Pages;

use App\Filament\Resources\WidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWidget extends ViewRecord
{
    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
