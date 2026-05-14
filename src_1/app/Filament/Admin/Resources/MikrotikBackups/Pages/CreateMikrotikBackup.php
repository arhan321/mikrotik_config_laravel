<?php

namespace App\Filament\Admin\Resources\MikrotikBackups\Pages;

use App\Filament\Admin\Resources\MikrotikBackups\MikrotikBackupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMikrotikBackup extends CreateRecord
{
    protected static string $resource = MikrotikBackupResource::class;
}
