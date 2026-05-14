<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationTemplates;

use App\Filament\Admin\Resources\ConfigurationTemplates\Pages\CreateConfigurationTemplate;
use App\Filament\Admin\Resources\ConfigurationTemplates\Pages\EditConfigurationTemplate;
use App\Filament\Admin\Resources\ConfigurationTemplates\Pages\ListConfigurationTemplates;
use App\Filament\Admin\Resources\ConfigurationTemplates\Pages\ViewConfigurationTemplate;
use App\Filament\Admin\Resources\ConfigurationTemplates\Schemas\ConfigurationTemplateForm;
use App\Filament\Admin\Resources\ConfigurationTemplates\Tables\ConfigurationTemplatesTable;
use App\Models\ConfigurationTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

final class ConfigurationTemplateResource extends Resource
{
    protected static ?string $model = ConfigurationTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-code-bracket-square';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'Configuration Templates';

    protected static ?string $modelLabel = 'Configuration Template';

    protected static ?string $pluralModelLabel = 'Configuration Templates';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ConfigurationTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigurationTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConfigurationTemplates::route('/'),
            'create' => CreateConfigurationTemplate::route('/create'),
            'view' => ViewConfigurationTemplate::route('/{record}'),
            'edit' => EditConfigurationTemplate::route('/{record}/edit'),
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
