<?php

namespace App\Filament\Admin\Resources\DeploymentDetails;

use App\Filament\Admin\Resources\DeploymentDetails\Pages\CreateDeploymentDetail;
use App\Filament\Admin\Resources\DeploymentDetails\Pages\EditDeploymentDetail;
use App\Filament\Admin\Resources\DeploymentDetails\Pages\ListDeploymentDetails;
use App\Filament\Admin\Resources\DeploymentDetails\Pages\ViewDeploymentDetail;
use App\Filament\Admin\Resources\DeploymentDetails\Schemas\DeploymentDetailForm;
use App\Filament\Admin\Resources\DeploymentDetails\Tables\DeploymentDetailsTable;
use App\Models\DeploymentDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DeploymentDetailResource extends Resource
{
    protected static ?string $model = DeploymentDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'Deployment Details';

    protected static ?string $modelLabel = 'Deployment Detail';

    protected static ?string $pluralModelLabel = 'Deployment Details';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return DeploymentDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeploymentDetailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeploymentDetails::route('/'),
            'create' => CreateDeploymentDetail::route('/create'),
            'view' => ViewDeploymentDetail::route('/{record}'),
            'edit' => EditDeploymentDetail::route('/{record}/edit'),
        ];
    }
}
