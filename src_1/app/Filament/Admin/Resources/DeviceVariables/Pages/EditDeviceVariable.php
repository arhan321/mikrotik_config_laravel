<?php

namespace App\Filament\Admin\Resources\DeviceVariables\Pages;

use App\Filament\Admin\Resources\DeviceVariables\DeviceVariableResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDeviceVariable extends EditRecord
{
    protected static string $resource = DeviceVariableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
