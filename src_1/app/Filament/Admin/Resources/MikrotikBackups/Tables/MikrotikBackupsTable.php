<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikBackups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class MikrotikBackupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('backup_name')
                    ->label('Nama Backup')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mikrotikDevice.name')
                    ->label('Device')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('backup_type')
                    ->label('Tipe')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        'running' => 'info',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('backup_path')
                    ->label('Path')
                    ->limit(40)
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('file_size')
                    ->label('Size')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'running' => 'Running',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ]),

                SelectFilter::make('backup_type')
                    ->label('Tipe')
                    ->options([
                        'export' => 'Export Script',
                        'backup' => 'Binary Backup',
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
