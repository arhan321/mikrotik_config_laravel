<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MikrotikDevice;
use RouterOS\Client;
use RouterOS\Query;
use Throwable;

final class MikrotikService
{
    public function makeClient(MikrotikDevice $device): Client
    {
        return new Client([
            'host' => $device->ip_address,
            'user' => $device->username,
            'pass' => $device->password,
            'port' => (int) $device->api_port,
            'timeout' => 10,
            'attempts' => 1,
            'delay' => 1,
        ]);
    }

    public function testConnection(MikrotikDevice $device): array
    {
        try {
            $client = $this->makeClient($device);

            $resource = $client
                ->query(new Query('/system/resource/print'))
                ->read();

            $identity = $client
                ->query(new Query('/system/identity/print'))
                ->read();

            $resourceData = $resource[0] ?? [];
            $identityData = $identity[0] ?? [];

            $device->update([
                'name' => $identityData['name'] ?? $device->name,
                'routeros_version' => $resourceData['version'] ?? null,
                'board_name' => $resourceData['board-name'] ?? null,
                'architecture_name' => $resourceData['architecture-name'] ?? null,
                'status' => 'online',
                'last_checked_at' => now(),
                'last_error' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Koneksi ke MikroTik berhasil.',
                'data' => [
                    'resource' => $resourceData,
                    'identity' => $identityData,
                ],
            ];
        } catch (Throwable $e) {
            $device->update([
                'status' => 'offline',
                'last_checked_at' => now(),
                'last_error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
