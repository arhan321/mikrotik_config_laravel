<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Throwable;
use Filament\Forms;
use RouterOS\Query;
use RouterOS\Client;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\MikrotikDevice;
use Illuminate\Support\Facades\Crypt;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

final class MikrotikMonitor extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationLabel = 'MikroTik Monitor';

    protected static ?string $title = 'MikroTik Monitor';

    protected static string|\UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.admin.pages.mikrotik-monitor';

    public ?array $data = [];

    public ?string $connectionStatus = null;

    public ?string $connectionMessage = null;

    public ?string $currentDeviceName = null;

    public ?string $lastCheckedAt = null;

    public array $resource = [];

    public array $identity = [];

    public array $routerboard = [];

    public array $interfaces = [];

    public array $addresses = [];

    public function mount(): void
    {
        $firstDeviceId = MikrotikDevice::query()
            ->orderBy('name')
            ->value('id');

        $this->form->fill([
            'mikrotik_device_id' => $firstDeviceId,
        ]);

        if ($firstDeviceId) {
            $this->loadDeviceInfo();
        }
    }

public function form(Schema $schema): Schema
{
    return $schema
        ->components([
            Forms\Components\Select::make('mikrotik_device_id')
                ->label('Pilih Device MikroTik')
                ->placeholder('Pilih router MikroTik')
                ->options(fn (): array => MikrotikDevice::query()
                    ->orderBy('name')
                    ->get()
                    ->mapWithKeys(function (MikrotikDevice $device): array {
                        return [
                            $device->id => "{$device->name} - {$device->ip_address}:{$device->api_port}",
                        ];
                    })
                    ->toArray())
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function (): void {
                    $this->loadDeviceInfo();
                }),
        ])
        ->statePath('data');
}

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Data')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->action('loadDeviceInfo'),
        ];
    }

    public function loadDeviceInfo(): void
    {
        $deviceId = data_get($this->data, 'mikrotik_device_id');

        $this->resetMonitorData();

        if (! $deviceId) {
            $this->connectionStatus = 'empty';
            $this->connectionMessage = 'Belum ada device MikroTik yang dipilih.';
            return;
        }

        /** @var MikrotikDevice|null $device */
        $device = MikrotikDevice::query()->find($deviceId);

        if (! $device) {
            $this->connectionStatus = 'failed';
            $this->connectionMessage = 'Device MikroTik tidak ditemukan di database.';
            return;
        }

        $this->currentDeviceName = $device->name;

        $startedAt = microtime(true);

        try {
            $client = $this->makeRouterClient($device);

            $resource = $client->query('/system/resource/print')->read();
            $identity = $client->query('/system/identity/print')->read();
            $routerboard = $client->query('/system/routerboard/print')->read();
            $interfaces = $client->query('/interface/print')->read();
            $addresses = $client->query('/ip/address/print')->read();

            $this->resource = $resource[0] ?? [];
            $this->identity = $identity[0] ?? [];
            $this->routerboard = $routerboard[0] ?? [];
            $this->interfaces = $interfaces;
            $this->addresses = $addresses;

            $this->connectionStatus = 'online';
            $this->connectionMessage = 'Berhasil terhubung ke MikroTik.';
            $this->lastCheckedAt = now()->format('d M Y H:i:s');

            $device->update([
                'status' => 'online',
                'routeros_version' => data_get($this->resource, 'version'),
                'board_name' => data_get($this->resource, 'board-name') ?: data_get($this->routerboard, 'model'),
                'architecture_name' => data_get($this->resource, 'architecture-name'),
                'last_checked_at' => now(),
                'last_error' => null,
            ]);

            Notification::make()
                ->title('Koneksi MikroTik berhasil')
                ->body("Device {$device->name} berhasil dibaca.")
                ->success()
                ->send();
        } catch (Throwable $e) {
            $durationMs = (int) ((microtime(true) - $startedAt) * 1000);

            $this->connectionStatus = 'failed';
            $this->connectionMessage = $e->getMessage();
            $this->lastCheckedAt = now()->format('d M Y H:i:s');

            $device->update([
                'status' => 'offline',
                'last_checked_at' => now(),
                'last_error' => $e->getMessage(),
            ]);

            Notification::make()
                ->title('Koneksi MikroTik gagal')
                ->body("Gagal membaca {$device->name}. Durasi: {$durationMs} ms. Error: {$e->getMessage()}")
                ->danger()
                ->send();
        }
    }

    private function resetMonitorData(): void
    {
        $this->connectionStatus = null;
        $this->connectionMessage = null;
        $this->currentDeviceName = null;
        $this->lastCheckedAt = null;

        $this->resource = [];
        $this->identity = [];
        $this->routerboard = [];
        $this->interfaces = [];
        $this->addresses = [];
    }

    private function makeRouterClient(MikrotikDevice $device): Client
    {
        return new Client([
            'host' => $device->ip_address,
            'user' => $device->username,
            'pass' => $this->resolvePassword($device),
            'port' => (int) $device->api_port,
            'timeout' => 10,
            'attempts' => 1,
        ]);
    }

    private function resolvePassword(MikrotikDevice $device): string
    {
        $password = (string) $device->password;

        try {
            return Crypt::decryptString($password);
        } catch (Throwable) {
            return $password;
        }
    }

    public function getCpuLoadProperty(): int
    {
        return (int) data_get($this->resource, 'cpu-load', 0);
    }

    public function getTotalMemoryProperty(): int
    {
        return (int) data_get($this->resource, 'total-memory', 0);
    }

    public function getFreeMemoryProperty(): int
    {
        return (int) data_get($this->resource, 'free-memory', 0);
    }

    public function getUsedMemoryProperty(): int
    {
        return max(0, $this->totalMemory - $this->freeMemory);
    }

    public function getMemoryUsagePercentProperty(): int
    {
        if ($this->totalMemory <= 0) {
            return 0;
        }

        return (int) round(($this->usedMemory / $this->totalMemory) * 100);
    }

    public function getTotalHddProperty(): int
    {
        return (int) data_get($this->resource, 'total-hdd-space', 0);
    }

    public function getFreeHddProperty(): int
    {
        return (int) data_get($this->resource, 'free-hdd-space', 0);
    }

    public function getUsedHddProperty(): int
    {
        return max(0, $this->totalHdd - $this->freeHdd);
    }

    public function getHddUsagePercentProperty(): int
    {
        if ($this->totalHdd <= 0) {
            return 0;
        }

        return (int) round(($this->usedHdd / $this->totalHdd) * 100);
    }

    public function getRunningInterfacesCountProperty(): int
    {
        return collect($this->interfaces)
            ->filter(fn (array $interface): bool => data_get($interface, 'running') === 'true')
            ->count();
    }

    public function getDisabledInterfacesCountProperty(): int
    {
        return collect($this->interfaces)
            ->filter(fn (array $interface): bool => data_get($interface, 'disabled') === 'true')
            ->count();
    }

    public function formatBytes(int|string|null $bytes): string
    {
        $bytes = (float) ($bytes ?: 0);

        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);

        return round($bytes / (1024 ** $power), 2) . ' ' . $units[$power];
    }
}