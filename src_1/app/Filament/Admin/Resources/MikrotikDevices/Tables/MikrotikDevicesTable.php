<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MikrotikDevices\Tables;

use App\Services\MikrotikService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

final class MikrotikDevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('api_port')
                    ->label('Port')
                    ->sortable(),

                TextColumn::make('username')
                    ->label('Username')
                    ->searchable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'online' => 'success',
                        'offline' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'online' => 'Online',
                        'offline' => 'Offline',
                        default => 'Belum Dicek',
                    })
                    ->sortable(),

                TextColumn::make('routeros_version')
                    ->label('RouterOS')
                    ->toggleable(),

                TextColumn::make('board_name')
                    ->label('Board')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('architecture_name')
                    ->label('Architecture')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('last_checked_at')
                    ->label('Terakhir Dicek')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'unchecked' => 'Belum Dicek',
                        'online' => 'Online',
                        'offline' => 'Offline',
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('test_connection')
                    ->label('Test Connection')
                    ->icon('heroicon-o-signal')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Test Connection MikroTik')
                    ->modalDescription('Sistem akan mencoba konek ke MikroTik menggunakan RouterOS API.')
                    ->modalSubmitActionLabel('Mulai Test')
                    ->action(function ($record): void {
                        $result = app(MikrotikService::class)->testConnection($record);

                        if ($result['success'] === true) {
                            Notification::make()
                                ->title('Koneksi Berhasil')
                                ->body($result['message'] ?? 'Laravel berhasil terhubung ke MikroTik.')
                                ->success()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Koneksi Gagal')
                            ->body($result['message'] ?? 'Laravel gagal terhubung ke MikroTik.')
                            ->danger()
                            ->send();
                    }),

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
