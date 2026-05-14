<?php

namespace App\Filament\Admin\Resources\DeviceVariables\Pages;

use App\Filament\Admin\Resources\DeviceVariables\DeviceVariableResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeviceVariable extends ViewRecord
{
    protected static string $resource = DeviceVariableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
