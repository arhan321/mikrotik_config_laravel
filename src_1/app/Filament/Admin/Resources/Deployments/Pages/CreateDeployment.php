<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Deployments\Pages;

use App\Filament\Admin\Resources\Deployments\DeploymentResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDeployment extends CreateRecord
{
    protected static string $resource = DeploymentResource::class;
}
