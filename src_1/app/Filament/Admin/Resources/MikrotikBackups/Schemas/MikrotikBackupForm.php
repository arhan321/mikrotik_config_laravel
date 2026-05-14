<?php

namespace App\Filament\Admin\Resources\MikrotikBackups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class MikrotikBackupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Backup')
                    ->schema([
                        Select::make('mikrotik_device_id')
                            ->label('MikroTik Device')
                            ->relationship('mikrotikDevice', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('created_by')
                            ->label('Dibuat Oleh')
                            ->relationship('creator', 'name')
                            ->default(fn (): ?int => Auth::id())
                            ->searchable()
                            ->preload(),

                        TextInput::make('backup_name')
                            ->label('Nama Backup')
                            ->default(fn (): string => 'backup-' . now()->format('Ymd-His'))
                            ->required()
                            ->maxLength(255),

                        Select::make('backup_type')
                            ->label('Tipe Backup')
                            ->options([
                                'export' => 'Export Script (.rsc)',
                                'backup' => 'Binary Backup (.backup)',
                            ])
                            ->default('export')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'running' => 'Running',
                                'success' => 'Success',
                                'failed' => 'Failed',
                            ])
                            ->default('pending')
                            ->required(),

                        TextInput::make('backup_path')
                            ->label('Path File')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('file_size')
                            ->label('Ukuran File')
                            ->numeric(),

                        DateTimePicker::make('started_at')
                            ->label('Mulai'),

                        DateTimePicker::make('finished_at')
                            ->label('Selesai'),

                        Textarea::make('backup_content')
                            ->label('Backup Content')
                            ->rows(8)
                            ->columnSpanFull(),

                        Textarea::make('error_message')
                            ->label('Error Message')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
