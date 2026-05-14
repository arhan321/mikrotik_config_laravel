<?php

namespace App\Filament\Admin\Resources\DeviceVariables;

use App\Filament\Admin\Resources\DeviceVariables\Pages\CreateDeviceVariable;
use App\Filament\Admin\Resources\DeviceVariables\Pages\EditDeviceVariable;
use App\Filament\Admin\Resources\DeviceVariables\Pages\ListDeviceVariables;
use App\Filament\Admin\Resources\DeviceVariables\Pages\ViewDeviceVariable;
use App\Filament\Admin\Resources\DeviceVariables\Schemas\DeviceVariableForm;
use App\Filament\Admin\Resources\DeviceVariables\Tables\DeviceVariablesTable;
use App\Models\DeviceVariable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DeviceVariableResource extends Resource
{
    protected static ?string $model = DeviceVariable::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-variable';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'Device Variables';

    protected static ?string $modelLabel = 'Device Variable';

    protected static ?string $pluralModelLabel = 'Device Variables';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return DeviceVariableForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceVariablesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeviceVariables::route('/'),
            'create' => CreateDeviceVariable::route('/create'),
            'view' => ViewDeviceVariable::route('/{record}'),
            'edit' => EditDeviceVariable::route('/{record}/edit'),
        ];
    }
}
