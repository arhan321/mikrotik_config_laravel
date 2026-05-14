<?php

namespace App\Filament\Admin\Resources\DeploymentDetails\Pages;

use App\Filament\Admin\Resources\DeploymentDetails\DeploymentDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDeploymentDetail extends EditRecord
{
    protected static string $resource = DeploymentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
