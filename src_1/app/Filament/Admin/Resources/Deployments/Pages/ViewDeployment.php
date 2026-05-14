<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Deployments\Pages;

use App\Filament\Admin\Resources\Deployments\DeploymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewDeployment extends ViewRecord
{
    protected static string $resource = DeploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
