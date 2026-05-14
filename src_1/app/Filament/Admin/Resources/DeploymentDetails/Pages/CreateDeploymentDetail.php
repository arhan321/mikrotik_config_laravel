<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeploymentDetails\Pages;

use App\Filament\Admin\Resources\DeploymentDetails\DeploymentDetailResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateDeploymentDetail extends CreateRecord
{
    protected static string $resource = DeploymentDetailResource::class;
}
