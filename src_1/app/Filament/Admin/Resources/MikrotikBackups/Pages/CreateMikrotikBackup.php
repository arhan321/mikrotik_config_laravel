<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikBackups\Pages;

use App\Filament\Admin\Resources\MikrotikBackups\MikrotikBackupResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMikrotikBackup extends CreateRecord
{
    protected static string $resource = MikrotikBackupResource::class;
}
