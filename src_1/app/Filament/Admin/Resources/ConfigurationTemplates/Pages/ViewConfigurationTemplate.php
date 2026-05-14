<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationTemplates\Pages;

use App\Filament\Admin\Resources\ConfigurationTemplates\ConfigurationTemplateResource;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewConfigurationTemplate extends ViewRecord
{
    protected static string $resource = ConfigurationTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            RestoreAction::make(),
        ];
    }
}
