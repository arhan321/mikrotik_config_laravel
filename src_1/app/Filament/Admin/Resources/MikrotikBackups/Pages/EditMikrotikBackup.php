<?php

namespace App\Filament\Admin\Resources\MikrotikBackups\Pages;

use App\Filament\Admin\Resources\MikrotikBackups\MikrotikBackupResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMikrotikBackup extends EditRecord
{
    protected static string $resource = MikrotikBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
