<?php

namespace App\Filament\Admin\Resources\MikrotikDevices\Pages;

use App\Filament\Admin\Resources\MikrotikDevices\MikrotikDeviceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMikrotikDevice extends EditRecord
{
    protected static string $resource = MikrotikDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
