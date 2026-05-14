<?php

namespace App\Filament\Admin\Resources\Deployments\Pages;

use App\Filament\Admin\Resources\Deployments\DeploymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeployment extends CreateRecord
{
    protected static string $resource = DeploymentResource::class;
}
