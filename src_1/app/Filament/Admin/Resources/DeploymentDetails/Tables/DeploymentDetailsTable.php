<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeploymentDetails\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class DeploymentDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deployment.deployment_code')
                    ->label('Deployment')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mikrotikDevice.name')
                    ->label('Device')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        'running' => 'info',
                        'skipped' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('duration_ms')
                    ->label('Durasi MS')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('started_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('finished_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'running' => 'Running',
                        'success' => 'Success',
                        'failed' => 'Failed',
                        'skipped' => 'Skipped',
                    ]),

                SelectFilter::make('mikrotik_device_id')
                    ->label('Device')
                    ->relationship('mikrotikDevice', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
