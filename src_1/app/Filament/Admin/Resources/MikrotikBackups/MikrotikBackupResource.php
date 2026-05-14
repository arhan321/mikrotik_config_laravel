<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikBackups;

use App\Filament\Admin\Resources\MikrotikBackups\Pages\CreateMikrotikBackup;
use App\Filament\Admin\Resources\MikrotikBackups\Pages\EditMikrotikBackup;
use App\Filament\Admin\Resources\MikrotikBackups\Pages\ListMikrotikBackups;
use App\Filament\Admin\Resources\MikrotikBackups\Pages\ViewMikrotikBackup;
use App\Filament\Admin\Resources\MikrotikBackups\Schemas\MikrotikBackupForm;
use App\Filament\Admin\Resources\MikrotikBackups\Tables\MikrotikBackupsTable;
use App\Models\MikrotikBackup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

final class MikrotikBackupResource extends Resource
{
    protected static ?string $model = MikrotikBackup::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'MikroTik Backups';

    protected static ?string $modelLabel = 'MikroTik Backup';

    protected static ?string $pluralModelLabel = 'MikroTik Backups';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'backup_name';

    public static function form(Schema $schema): Schema
    {
        return MikrotikBackupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MikrotikBackupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMikrotikBackups::route('/'),
            'create' => CreateMikrotikBackup::route('/create'),
            'view' => ViewMikrotikBackup::route('/{record}'),
            'edit' => EditMikrotikBackup::route('/{record}/edit'),
        ];
    }
}
