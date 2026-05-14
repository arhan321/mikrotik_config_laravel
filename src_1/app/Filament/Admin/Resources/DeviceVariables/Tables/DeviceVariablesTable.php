<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\DeviceVariables\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class DeviceVariablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mikrotikDevice.name')
                    ->label('Device')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('variable_key')
                    ->label('Key')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('variable_value')
                    ->label('Value')
                    ->limit(40)
                    ->searchable(),

                IconColumn::make('is_secret')
                    ->label('Secret')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
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
