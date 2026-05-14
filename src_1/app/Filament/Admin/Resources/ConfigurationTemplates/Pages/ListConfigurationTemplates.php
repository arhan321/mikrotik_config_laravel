<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationTemplates\Pages;

use App\Filament\Admin\Resources\ConfigurationTemplates\ConfigurationTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListConfigurationTemplates extends ListRecords
{
    protected static string $resource = ConfigurationTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
