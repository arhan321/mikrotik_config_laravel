<?php

namespace App\Filament\Admin\Resources\ConfigurationTemplates\Pages;

use App\Filament\Admin\Resources\ConfigurationTemplates\ConfigurationTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditConfigurationTemplate extends EditRecord
{
    protected static string $resource = ConfigurationTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
