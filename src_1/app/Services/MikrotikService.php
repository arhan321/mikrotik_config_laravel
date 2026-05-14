<?php

namespace App\Services;

use Throwable;
use RouterOS\Query;
use RouterOS\Client;
use App\Models\MikrotikDevice;

class MikrotikService
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

    public function getInterfaces(MikrotikDevice $device): array
    {
        try {
            $client = $this->makeClient($device);

            $response = $client
                ->query(new Query('/interface/print'))
                ->read();

            return [
                'success' => true,
                'message' => 'Daftar interface berhasil diambil.',
                'data' => $response,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function getIpAddresses(MikrotikDevice $device): array
    {
        try {
            $client = $this->makeClient($device);

            $response = $client
                ->query(new Query('/ip/address/print'))
                ->read();

            return [
                'success' => true,
                'message' => 'Daftar IP address berhasil diambil.',
                'data' => $response,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    public function addIpAddress(
        MikrotikDevice $device,
        string $address,
        string $interface,
        ?string $comment = null
    ): array {
        try {
            $client = $this->makeClient($device);

            $query = (new Query('/ip/address/add'))
                ->equal('address', trim($address))
                ->equal('interface', trim($interface));

            if (filled($comment)) {
                $query->equal('comment', trim($comment));
            }

            $response = $client
                ->query($query)
                ->read();

            return [
                'success' => true,
                'message' => "IP {$address} berhasil ditambahkan ke {$interface}.",
                'data' => $response,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    public function removeIpAddress(MikrotikDevice $device, string $id): array
    {
        try {
            $client = $this->makeClient($device);

            $response = $client
                ->query(
                    (new Query('/ip/address/remove'))
                        ->equal('numbers', $id)
                )
                ->read();

            return [
                'success' => true,
                'message' => 'IP address berhasil dihapus.',
                'data' => $response,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        }
    }
}
