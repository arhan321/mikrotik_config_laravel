<?php

namespace App\Filament\Admin\Resources\DeviceVariables\Pages;

use App\Filament\Admin\Resources\DeviceVariables\DeviceVariableResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeviceVariables extends ListRecords
{
    protected static string $resource = DeviceVariableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
