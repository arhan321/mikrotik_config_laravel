<?php

namespace App\Filament\Admin\Resources\Deployments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class DeploymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Deployment')
                    ->schema([
                        TextInput::make('deployment_code')
                            ->label('Kode Deployment')
                            ->default(fn (): string => 'DPLY-' . now()->format('YmdHis'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('configuration_template_id')
                            ->label('Template')
                            ->relationship('configurationTemplate', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->default(fn (): ?int => Auth::id())
                            ->searchable()
                            ->preload(),

                        Select::make('mode')
                            ->label('Mode')
                            ->options([
                                'single' => 'Single Device',
                                'bulk' => 'Bulk Deployment',
                            ])
                            ->default('single')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'running' => 'Running',
                                'success' => 'Success',
                                'partial_success' => 'Partial Success',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),

                        TextInput::make('total_devices')
                            ->label('Total Device')
                            ->numeric()
                            ->default(0),

                        TextInput::make('success_count')
                            ->label('Berhasil')
                            ->numeric()
                            ->default(0),

                        TextInput::make('failed_count')
                            ->label('Gagal')
                            ->numeric()
                            ->default(0),

                        DateTimePicker::make('started_at')
                            ->label('Mulai'),

                        DateTimePicker::make('finished_at')
                            ->label('Selesai'),

                        TextInput::make('duration_ms')
                            ->label('Durasi MS')
                            ->numeric(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
