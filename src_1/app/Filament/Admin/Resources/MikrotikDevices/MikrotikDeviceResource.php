<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices;

use App\Filament\Admin\Resources\MikrotikDevices\Pages\CreateMikrotikDevice;
use App\Filament\Admin\Resources\MikrotikDevices\Pages\EditMikrotikDevice;
use App\Filament\Admin\Resources\MikrotikDevices\Pages\ListMikrotikDevices;
use App\Filament\Admin\Resources\MikrotikDevices\Pages\ViewMikrotikDevice;
use App\Filament\Admin\Resources\MikrotikDevices\Schemas\MikrotikDeviceForm;
use App\Filament\Admin\Resources\MikrotikDevices\Tables\MikrotikDevicesTable;
use App\Models\MikrotikDevice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

final class MikrotikDeviceResource extends Resource
{
    protected static ?string $model = MikrotikDevice::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-server-stack';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'MikroTik Devices';

    protected static ?string $modelLabel = 'MikroTik Device';

    protected static ?string $pluralModelLabel = 'MikroTik Devices';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return MikrotikDeviceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MikrotikDevicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMikrotikDevices::route('/'),
            'create' => CreateMikrotikDevice::route('/create'),
            'view' => ViewMikrotikDevice::route('/{record}'),
            'edit' => EditMikrotikDevice::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
