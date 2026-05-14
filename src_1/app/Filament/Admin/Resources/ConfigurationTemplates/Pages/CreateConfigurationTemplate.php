<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationTemplates\Pages;

use App\Filament\Admin\Resources\ConfigurationTemplates\ConfigurationTemplateResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateConfigurationTemplate extends CreateRecord
{
    protected static string $resource = ConfigurationTemplateResource::class;
}
