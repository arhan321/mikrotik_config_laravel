<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class MikrotikDeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Perangkat')
                    ->description('Data utama perangkat MikroTik yang akan dihubungkan ke Laravel melalui RouterOS API.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Device')
                            ->placeholder('MTK-LAB-01')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('192.168.88.1')
                            ->required()
                            ->maxLength(45),

                        TextInput::make('api_port')
                            ->label('API Port')
                            ->numeric()
                            ->default(8728)
                            ->required()
                            ->minValue(1)
                            ->maxValue(65535),

                        TextInput::make('username')
                            ->label('Username MikroTik')
                            ->placeholder('laravel-api')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password MikroTik')
                            ->password()
                            ->revealable()
                            ->autocomplete(false)
                            ->formatStateUsing(fn (): ?string => null)
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->helperText('Kosongkan saat edit jika password tidak ingin diubah.'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'unchecked' => 'Belum Dicek',
                                'online' => 'Online',
                                'offline' => 'Offline',
                            ])
                            ->default('unchecked')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Detail Tambahan')
                    ->schema([
                        TextInput::make('location')
                            ->label('Lokasi')
                            ->placeholder('Lab Jaringan / Rumah / Kampus')
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('routeros_version')
                            ->label('RouterOS Version')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('board_name')
                            ->label('Board Name')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('architecture_name')
                            ->label('Architecture')
                            ->disabled()
                            ->dehydrated(false),

                        DateTimePicker::make('last_checked_at')
                            ->label('Terakhir Dicek')
                            ->disabled()
                            ->dehydrated(false),

                        Textarea::make('last_error')
                            ->label('Error Terakhir')
                            ->rows(3)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
