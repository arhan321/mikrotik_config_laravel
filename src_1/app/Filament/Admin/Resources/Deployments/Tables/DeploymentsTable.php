<?php

namespace App\Filament\Admin\Resources\Deployments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DeploymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('deployment_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('configurationTemplate.name')
                    ->label('Template')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mode')
                    ->label('Mode')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'partial_success' => 'warning',
                        'failed' => 'danger',
                        'running' => 'info',
                        'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('total_devices')
                    ->label('Total')
                    ->sortable(),

                TextColumn::make('success_count')
                    ->label('Berhasil')
                    ->color('success')
                    ->sortable(),

                TextColumn::make('failed_count')
                    ->label('Gagal')
                    ->color('danger')
                    ->sortable(),

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
                        'partial_success' => 'Partial Success',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('mode')
                    ->label('Mode')
                    ->options([
                        'single' => 'Single',
                        'bulk' => 'Bulk',
                    ]),
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
