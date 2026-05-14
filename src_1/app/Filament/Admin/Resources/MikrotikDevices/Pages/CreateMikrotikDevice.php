<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices\Pages;

use App\Filament\Admin\Resources\MikrotikDevices\MikrotikDeviceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMikrotikDevice extends CreateRecord
{
    protected static string $resource = MikrotikDeviceResource::class;
}
