<?php

namespace App\Filament\Admin\Resources\Deployments\Pages;

use App\Filament\Admin\Resources\Deployments\DeploymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeployment extends ViewRecord
{
    protected static string $resource = DeploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
