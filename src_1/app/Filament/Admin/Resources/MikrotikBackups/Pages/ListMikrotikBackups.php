<?php

namespace App\Filament\Admin\Resources\MikrotikBackups\Pages;

use App\Filament\Admin\Resources\MikrotikBackups\MikrotikBackupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMikrotikBackups extends ListRecords
{
    protected static string $resource = MikrotikBackupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
