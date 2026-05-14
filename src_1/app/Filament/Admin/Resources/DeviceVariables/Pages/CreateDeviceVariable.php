<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeviceVariables\Pages;

use App\Filament\Admin\Resources\DeviceVariables\DeviceVariableResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDeviceVariable extends CreateRecord
{
    protected static string $resource = DeviceVariableResource::class;
}
