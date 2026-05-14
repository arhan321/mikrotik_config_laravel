<?php

namespace App\Filament\Admin\Resources\DeploymentDetails\Pages;

use App\Filament\Admin\Resources\DeploymentDetails\DeploymentDetailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeploymentDetail extends ViewRecord
{
    protected static string $resource = DeploymentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
