<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices\Pages;

use App\Filament\Admin\Resources\MikrotikDevices\MikrotikDeviceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListMikrotikDevices extends ListRecords
{
    protected static string $resource = MikrotikDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
