<?php

namespace App\Filament\Admin\Resources\Deployments;

use App\Filament\Admin\Resources\Deployments\Pages\CreateDeployment;
use App\Filament\Admin\Resources\Deployments\Pages\EditDeployment;
use App\Filament\Admin\Resources\Deployments\Pages\ListDeployments;
use App\Filament\Admin\Resources\Deployments\Pages\ViewDeployment;
use App\Filament\Admin\Resources\Deployments\Schemas\DeploymentForm;
use App\Filament\Admin\Resources\Deployments\Tables\DeploymentsTable;
use App\Models\Deployment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DeploymentResource extends Resource
{
    protected static ?string $model = Deployment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rocket-launch';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'Deployments';

    protected static ?string $modelLabel = 'Deployment';

    protected static ?string $pluralModelLabel = 'Deployments';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'deployment_code';

    public static function form(Schema $schema): Schema
    {
        return DeploymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeploymentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeployments::route('/'),
            'create' => CreateDeployment::route('/create'),
            'view' => ViewDeployment::route('/{record}'),
            'edit' => EditDeployment::route('/{record}/edit'),
        ];
    }
}
