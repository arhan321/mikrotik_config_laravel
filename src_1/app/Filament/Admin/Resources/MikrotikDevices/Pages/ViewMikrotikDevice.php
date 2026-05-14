<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices\Pages;

use App\Filament\Admin\Resources\MikrotikDevices\MikrotikDeviceResource;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewMikrotikDevice extends ViewRecord
{
    protected static string $resource = MikrotikDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            RestoreAction::make(),
        ];
    }
}
