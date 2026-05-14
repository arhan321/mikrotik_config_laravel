<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeviceVariables\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class DeviceVariableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Variable Perangkat')
                    ->schema([
                        Select::make('mikrotik_device_id')
                            ->label('MikroTik Device')
                            ->relationship('mikrotikDevice', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        TextInput::make('variable_key')
                            ->label('Variable Key')
                            ->placeholder('router_name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('variable_value')
                            ->label('Variable Value')
                            ->placeholder('MTK-LAB-01')
                            ->rows(4)
                            ->columnSpanFull(),

                        Toggle::make('is_secret')
                            ->label('Secret')
                            ->helperText('Aktifkan jika value berisi data sensitif seperti password.')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }
}
