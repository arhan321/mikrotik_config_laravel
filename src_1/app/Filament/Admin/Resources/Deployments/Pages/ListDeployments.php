<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Deployments\Pages;

use App\Filament\Admin\Resources\Deployments\DeploymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListDeployments extends ListRecords
{
    protected static string $resource = DeploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
