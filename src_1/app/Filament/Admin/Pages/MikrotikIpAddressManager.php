<?php

namespace App\Filament\Admin\Pages;

use App\Models\MikrotikDevice;
use App\Services\MikrotikService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class MikrotikIpAddressManager extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static string|UnitEnum|null $navigationGroup = 'MikroTik Automation';

    protected static ?string $navigationLabel = 'IP Address Manager';

    protected static ?string $title = 'IP Address Manager';

    protected static ?int $navigationSort = 7;

    protected string $view = 'filament.admin.pages.mikrotik-ip-address-manager';

    public ?int $selectedDeviceId = null;

    /**
     * @var array<int, array{id:int,name:string,ip_address:string,status:string|null}>
     */
    public array $devices = [];

    /**
     * @var array<int, array{id:string|null,name:string,type:string|null,running:bool,disabled:bool,mac_address:string|null}>
     */
    public array $interfaces = [];

    /**
     * @var array<int, array{id:string|null,address:string|null,network:string|null,interface:string|null,comment:string|null,disabled:bool,dynamic:bool}>
     */
    public array $ipAddresses = [];

    public string $address = '';

    public string $interface = '';

    public ?string $comment = '';

    public ?string $lastMessage = null;

    public function mount(): void
    {
        $this->loadDevices();

        if (blank($this->selectedDeviceId) && count($this->devices) === 1) {
            $this->selectedDeviceId = $this->devices[0]['id'];
            $this->loadRouterData();
        }
    }

    public function updatedSelectedDeviceId(): void
    {
        $this->loadRouterData();
    }

    public function loadDevices(): void
    {
        $this->devices = MikrotikDevice::query()
            ->orderBy('name')
            ->get(['id', 'name', 'ip_address', 'status'])
            ->map(fn (MikrotikDevice $device): array => [
                'id' => $device->id,
                'name' => $device->name,
                'ip_address' => $device->ip_address,
                'status' => $device->status,
            ])
            ->values()
            ->all();
    }

    public function loadRouterData(): void
    {
        $this->interfaces = [];
        $this->ipAddresses = [];
        $this->lastMessage = null;

        $device = $this->selectedDevice();

        if (! $device) {
            return;
        }

        $service = app(MikrotikService::class);

        $interfacesResult = $service->getInterfaces($device);

        if (! $interfacesResult['success']) {
            $this->notifyError('Gagal mengambil interface', $interfacesResult['message']);
            return;
        }

        $ipResult = $service->getIpAddresses($device);

        if (! $ipResult['success']) {
            $this->notifyError('Gagal mengambil IP address', $ipResult['message']);
            return;
        }

        $this->interfaces = collect($interfacesResult['data'] ?? [])
            ->map(fn (array $item): array => [
                'id' => $item['.id'] ?? null,
                'name' => $item['name'] ?? '-',
                'type' => $item['type'] ?? null,
                'running' => $this->truthy($item['running'] ?? false),
                'disabled' => $this->truthy($item['disabled'] ?? false),
                'mac_address' => $item['mac-address'] ?? null,
            ])
            ->sortBy('name')
            ->values()
            ->all();

        $this->ipAddresses = collect($ipResult['data'] ?? [])
            ->map(fn (array $item): array => [
                'id' => $item['.id'] ?? null,
                'address' => $item['address'] ?? null,
                'network' => $item['network'] ?? null,
                'interface' => $item['interface'] ?? null,
                'comment' => $item['comment'] ?? null,
                'disabled' => $this->truthy($item['disabled'] ?? false),
                'dynamic' => $this->truthy($item['dynamic'] ?? false),
            ])
            ->sortBy('interface')
            ->values()
            ->all();

        if (blank($this->interface) && count($this->interfaces) > 0) {
            $firstRunningInterface = collect($this->interfaces)->first(fn (array $item): bool => $item['running'] && ! $item['disabled']);

            $this->interface = $firstRunningInterface['name'] ?? $this->interfaces[0]['name'];
        }

        $this->lastMessage = 'Data MikroTik berhasil dimuat.';

        Notification::make()
            ->title('Data Berhasil Dimuat')
            ->body('Interface dan IP address berhasil dibaca dari MikroTik.')
            ->success()
            ->send();
    }

    public function addIpAddress(): void
    {
        $this->validate([
            'selectedDeviceId' => ['required', 'exists:mikrotik_devices,id'],
            'address' => [
                'required',
                'string',
                'max:64',
                'regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}\/([0-9]|[12][0-9]|3[0-2])$/',
            ],
            'interface' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:255'],
        ], [
            'address.regex' => 'Format IP harus menggunakan CIDR, contoh: 192.168.20.1/24.',
        ]);

        $device = $this->selectedDevice();

        if (! $device) {
            $this->notifyError('Device tidak ditemukan', 'Silakan pilih MikroTik device terlebih dahulu.');
            return;
        }

        $result = app(MikrotikService::class)->addIpAddress(
            device: $device,
            address: $this->address,
            interface: $this->interface,
            comment: $this->comment
        );

        if (! $result['success']) {
            $this->notifyError('Gagal Menambahkan IP', $result['message']);
            return;
        }

        Notification::make()
            ->title('IP Berhasil Ditambahkan')
            ->body($result['message'])
            ->success()
            ->send();

        $this->address = '';
        $this->comment = '';

        $this->loadRouterData();
    }

    public function removeIpAddress(string $id, ?string $address = null): void
    {
        $device = $this->selectedDevice();

        if (! $device) {
            $this->notifyError('Device tidak ditemukan', 'Silakan pilih MikroTik device terlebih dahulu.');
            return;
        }

        if (blank($id)) {
            $this->notifyError('ID IP tidak valid', 'Data IP address dari MikroTik tidak memiliki ID.');
            return;
        }

        $result = app(MikrotikService::class)->removeIpAddress($device, $id);

        if (! $result['success']) {
            $this->notifyError('Gagal Menghapus IP', $result['message']);
            return;
        }

        Notification::make()
            ->title('IP Berhasil Dihapus')
            ->body(filled($address) ? "IP {$address} berhasil dihapus." : $result['message'])
            ->success()
            ->send();

        $this->loadRouterData();
    }

    private function selectedDevice(): ?MikrotikDevice
    {
        if (blank($this->selectedDeviceId)) {
            return null;
        }

        return MikrotikDevice::query()->find($this->selectedDeviceId);
    }

    private function truthy(mixed $value): bool
    {
        return in_array($value, [true, 1, '1', 'true', 'yes'], true);
    }

    private function notifyError(string $title, ?string $message = null): void
    {
        Notification::make()
            ->title($title)
            ->body($message ?: 'Terjadi kesalahan.')
            ->danger()
            ->send();
    }
}
