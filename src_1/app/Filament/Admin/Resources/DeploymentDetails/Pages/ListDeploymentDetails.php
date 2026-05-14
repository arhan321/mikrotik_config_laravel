<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeploymentDetails\Pages;

use App\Filament\Admin\Resources\DeploymentDetails\DeploymentDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListDeploymentDetails extends ListRecords
{
    protected static string $resource = DeploymentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
