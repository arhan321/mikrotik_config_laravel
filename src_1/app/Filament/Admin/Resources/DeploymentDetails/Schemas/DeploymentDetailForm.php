<?php

namespace App\Filament\Admin\Resources\DeploymentDetails\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DeploymentDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Deployment')
                    ->schema([
                        Select::make('deployment_id')
                            ->label('Deployment')
                            ->relationship('deployment', 'deployment_code')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('mikrotik_device_id')
                            ->label('MikroTik Device')
                            ->relationship('mikrotikDevice', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'running' => 'Running',
                                'success' => 'Success',
                                'failed' => 'Failed',
                                'skipped' => 'Skipped',
                            ])
                            ->default('pending')
                            ->required(),

                        TextInput::make('duration_ms')
                            ->label('Durasi MS')
                            ->numeric(),

                        DateTimePicker::make('started_at')
                            ->label('Mulai'),

                        DateTimePicker::make('finished_at')
                            ->label('Selesai'),

                        Textarea::make('command_sent')
                            ->label('Command Sent')
                            ->rows(8)
                            ->columnSpanFull(),

                        Textarea::make('response_message')
                            ->label('Response Message')
                            ->rows(6)
                            ->columnSpanFull(),

                        Textarea::make('error_message')
                            ->label('Error Message')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
