<?php

namespace App\Filament\Admin\Resources\DeploymentDetails\Pages;

use App\Filament\Admin\Resources\DeploymentDetails\DeploymentDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeploymentDetail extends CreateRecord
{
    protected static string $resource = DeploymentDetailResource::class;
}
