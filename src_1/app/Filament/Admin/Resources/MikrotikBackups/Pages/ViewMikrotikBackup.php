<?php

namespace App\Filament\Admin\Resources\MikrotikBackups\Pages;

use App\Filament\Admin\Resources\MikrotikBackups\MikrotikBackupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMikrotikBackup extends ViewRecord
{
    protected static string $resource = MikrotikBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
