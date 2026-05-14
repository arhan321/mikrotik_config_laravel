# Sistem Otomatisasi Konfigurasi MikroTik Berbasis Web

Project ini adalah aplikasi web berbasis **Laravel + Filament** yang digunakan untuk mengelola dan mengotomatisasi konfigurasi perangkat **MikroTik RouterOS** melalui **RouterOS API**.

Aplikasi ini dibuat untuk membantu admin jaringan melakukan konfigurasi MikroTik secara lebih cepat, terpusat, terdokumentasi, dan dapat diuji ulang. Fitur utama yang dikembangkan meliputi manajemen perangkat MikroTik, test koneksi RouterOS API, template konfigurasi, variabel per perangkat, deployment konfigurasi, backup konfigurasi, dan log hasil deployment.

---

## 1. Tujuan Project

Tujuan utama project ini adalah membangun sistem web yang dapat:

1. Menyimpan data perangkat MikroTik secara terpusat.
2. Menghubungkan Laravel ke MikroTik menggunakan RouterOS API.
3. Menguji koneksi perangkat MikroTik dari halaman admin Filament.
4. Membuat template konfigurasi MikroTik berbasis variable placeholder.
5. Mengisi nilai variable untuk masing-masing perangkat MikroTik.
6. Menghasilkan konfigurasi final dari template dan variable.
7. Melakukan deployment konfigurasi ke satu atau banyak perangkat.
8. Menyimpan riwayat deployment berhasil dan gagal.
9. Melakukan backup konfigurasi MikroTik.
10. Menjadi bahan penelitian tugas akhir untuk membandingkan konfigurasi manual dan otomatis.

---

## 2. Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend | Laravel |
| Admin Panel | Filament |
| Database | MySQL / MariaDB |
| Integrasi MikroTik | RouterOS API |
| Package RouterOS API | `evilfreelancer/routeros-api-php` |
| Queue | Laravel Queue, opsional untuk deployment massal |
| Web Server | Nginx / Apache |
| Container | Docker / Docker Compose |
| PHP Extension Wajib | `sockets` |

---

## 3. Gambaran Arsitektur Sistem

```text
Admin / Teknisi
    ↓
Browser
    ↓
Laravel Application
    ↓
Filament Admin Panel
    ↓
MikrotikService / DeploymentService
    ↓
RouterOS API Client
    ↓
MikroTik RouterOS Device
```

Database digunakan untuk menyimpan data user, perangkat MikroTik, template konfigurasi, variable perangkat, deployment, detail deployment, backup, dan log.

---

## 4. Alur Kerja Sistem

### 4.1 Alur Test Connection

```text
Admin membuka menu MikroTik Devices
    ↓
Admin mengisi data perangkat MikroTik
    ↓
Admin klik tombol Test Connection
    ↓
Laravel membaca IP, port, username, dan password device
    ↓
Laravel membuat koneksi RouterOS API
    ↓
Laravel menjalankan command:
/system/resource/print
/system/identity/print
    ↓
Jika berhasil:
- status device menjadi online
- routeros_version terisi
- board_name terisi
- architecture_name terisi
- last_checked_at diperbarui

Jika gagal:
- status device menjadi offline
- last_error terisi pesan error
```

### 4.2 Alur Template Configuration

```text
Admin membuat template konfigurasi
    ↓
Template berisi placeholder seperti {{router_name}} dan {{dns_server}}
    ↓
Sistem mendeteksi daftar variable
    ↓
Admin mengisi value variable untuk setiap device
    ↓
Sistem mengganti placeholder dengan value asli
    ↓
Sistem menghasilkan command final
```

Contoh template:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Contoh variable:

```text
router_name = MTK-LAB-01
dns_server  = 8.8.8.8,1.1.1.1
```

Hasil command final:

```mikrotik
/system identity set name=MTK-LAB-01
/ip dns set servers=8.8.8.8,1.1.1.1 allow-remote-requests=yes
```

### 4.3 Alur Deployment

```text
Admin memilih template
    ↓
Admin memilih satu atau banyak device target
    ↓
Sistem mengambil variable milik masing-masing device
    ↓
Sistem membuat command final untuk tiap device
    ↓
Sistem mengirim command ke MikroTik via RouterOS API
    ↓
Sistem menyimpan hasil ke deployments dan deployment_details
    ↓
Admin melihat status sukses atau gagal di Filament
```

---

## 5. Struktur Menu Filament

Menu utama berada pada grup:

```text
MikroTik Automation
```

Isi menu:

```text
MikroTik Automation
├── MikroTik Devices
├── Configuration Templates
├── Device Variables
├── Deployments
├── Deployment Details
└── MikroTik Backups
```

### 5.1 MikroTik Devices

Menu ini digunakan untuk menyimpan dan mengelola data perangkat MikroTik.

Data yang disimpan:

| Field | Keterangan |
|---|---|
| name | Nama perangkat |
| ip_address | IP MikroTik |
| api_port | Port RouterOS API, default 8728 |
| username | Username MikroTik |
| password | Password MikroTik, disimpan terenkripsi |
| location | Lokasi perangkat |
| description | Keterangan tambahan |
| routeros_version | Versi RouterOS hasil test connection |
| board_name | Board MikroTik hasil test connection |
| architecture_name | Arsitektur perangkat |
| status | unchecked, online, offline |
| last_checked_at | Waktu terakhir test connection |
| last_error | Pesan error terakhir |

Contoh data:

```text
Name       : MTK-LAB-01
IP Address : 192.168.88.1
API Port   : 8728
Username   : laravel-api
Password   : LaravelApi12345
Location   : Lab MikroTik
Status     : unchecked
```

### 5.2 Configuration Templates

Menu ini digunakan untuk membuat template command MikroTik.

Contoh:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Field penting:

| Field | Keterangan |
|---|---|
| name | Nama template |
| slug | Slug unik template |
| category | Kategori template |
| description | Penjelasan template |
| script_content | Isi command template |
| variables | Daftar variable yang digunakan |
| is_active | Status aktif template |
| created_by | User pembuat template |

### 5.3 Device Variables

Menu ini digunakan untuk mengisi value variable pada setiap perangkat.

Contoh:

| Device | Variable Key | Variable Value |
|---|---|---|
| MTK-LAB-01 | router_name | MTK-LAB-01 |
| MTK-LAB-01 | dns_server | 8.8.8.8,1.1.1.1 |

Dengan konsep ini, satu template bisa digunakan untuk banyak perangkat, tetapi setiap perangkat dapat memiliki nilai variable yang berbeda.

### 5.4 Deployments

Menu ini menyimpan proses deployment utama.

Field penting:

| Field | Keterangan |
|---|---|
| deployment_code | Kode unik deployment |
| configuration_template_id | Template yang digunakan |
| user_id | User yang menjalankan deployment |
| mode | single atau bulk |
| status | pending, running, success, partial_success, failed, cancelled |
| total_devices | Jumlah device target |
| success_count | Jumlah deployment berhasil |
| failed_count | Jumlah deployment gagal |
| started_at | Waktu mulai |
| finished_at | Waktu selesai |
| duration_ms | Durasi proses |

### 5.5 Deployment Details

Menu ini menyimpan detail deployment per device.

Jika deployment massal dijalankan ke 10 device, maka akan ada 1 data di tabel `deployments` dan 10 data di tabel `deployment_details`.

Field penting:

| Field | Keterangan |
|---|---|
| deployment_id | ID deployment utama |
| mikrotik_device_id | Device target |
| status | Status tiap device |
| command_sent | Command final yang dikirim |
| response_message | Response dari MikroTik |
| error_message | Error jika gagal |
| started_at | Waktu mulai per device |
| finished_at | Waktu selesai per device |
| duration_ms | Durasi proses per device |

### 5.6 MikroTik Backups

Menu ini digunakan untuk menyimpan data backup konfigurasi MikroTik.

Jenis backup:

1. `export` untuk file script `.rsc`
2. `backup` untuk file binary `.backup`

Field penting:

| Field | Keterangan |
|---|---|
| mikrotik_device_id | Device yang di-backup |
| created_by | User yang membuat backup |
| backup_name | Nama backup |
| backup_type | export atau backup |
| status | pending, running, success, failed |
| backup_path | Lokasi file backup |
| backup_content | Isi backup jika disimpan di database |
| file_size | Ukuran file |
| error_message | Error jika gagal |

---

## 6. Struktur Model dan Relasi

### 6.1 MikrotikDevice

Relasi:

```php
public function variables(): HasMany
{
    return $this->hasMany(DeviceVariable::class, 'mikrotik_device_id');
}

public function deploymentDetails(): HasMany
{
    return $this->hasMany(DeploymentDetail::class, 'mikrotik_device_id');
}

public function backups(): HasMany
{
    return $this->hasMany(MikrotikBackup::class, 'mikrotik_device_id');
}
```

Catatan penting:

```php
protected $casts = [
    'api_port' => 'integer',
    'password' => 'encrypted',
    'last_checked_at' => 'datetime',
];
```

Password MikroTik disimpan dengan cast `encrypted`, sehingga tidak tersimpan sebagai plaintext.

### 6.2 ConfigurationTemplate

Relasi:

```php
public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}

public function deployments(): HasMany
{
    return $this->hasMany(Deployment::class, 'configuration_template_id');
}
```

### 6.3 DeviceVariable

Relasi:

```php
public function mikrotikDevice(): BelongsTo
{
    return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
}
```

### 6.4 Deployment

Relasi:

```php
public function configurationTemplate(): BelongsTo
{
    return $this->belongsTo(ConfigurationTemplate::class, 'configuration_template_id');
}

public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

public function details(): HasMany
{
    return $this->hasMany(DeploymentDetail::class, 'deployment_id');
}
```

### 6.5 DeploymentDetail

Relasi:

```php
public function deployment(): BelongsTo
{
    return $this->belongsTo(Deployment::class, 'deployment_id');
}

public function mikrotikDevice(): BelongsTo
{
    return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
}
```

### 6.6 MikrotikBackup

Relasi:

```php
public function mikrotikDevice(): BelongsTo
{
    return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
}

public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}
```

---

## 7. Persiapan MikroTik

### 7.1 Set IP MikroTik

Contoh IP MikroTik:

```mikrotik
/ip address add address=192.168.88.1/24 interface=ether1 comment="LAN Laravel Lab"
```

Pastikan laptop atau server Laravel berada satu jaringan.

Contoh IP laptop/server Laravel:

```text
IP Address : 192.168.88.10
Subnet     : 255.255.255.0
Gateway    : 192.168.88.1
```

### 7.2 Aktifkan RouterOS API

```mikrotik
/ip service enable api
/ip service set api port=8728
/ip service set api address=192.168.88.0/24
```

### 7.3 Buat User Khusus Laravel

```mikrotik
/user group add name=laravel-api policy=read,write,api,test,sensitive
/user add name=laravel-api password="LaravelApi12345" group=laravel-api
```

Data ini nanti dimasukkan ke menu `MikroTik Devices`.

### 7.4 Test Port API dari Windows

```powershell
Test-NetConnection 192.168.88.1 -Port 8728
```

Jika berhasil:

```text
TcpTestSucceeded : True
```

---

## 8. Persiapan Docker PHP

Package RouterOS API membutuhkan extension PHP `sockets`.

Pastikan Dockerfile PHP memiliki:

```dockerfile
docker-php-ext-install sockets
```

Contoh bagian install extension:

```dockerfile
RUN docker-php-ext-install \
    soap \
    exif \
    pcntl \
    intl \
    gmp \
    zip \
    pdo_mysql \
    pdo_pgsql \
    bcmath \
    sockets
```

Setelah mengubah Dockerfile:

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

Masuk ke container:

```bash
docker exec -it php_laravel bash
```

Cek extension:

```bash
php -m | grep sockets
```

Jika muncul:

```text
sockets
```

maka extension sudah aktif.

---

## 9. Install Package RouterOS API

Jalankan di dalam container Laravel:

```bash
composer require evilfreelancer/routeros-api-php
```

Setelah selesai:

```bash
php artisan optimize:clear
composer dump-autoload
```

---

## 10. MikrotikService

Service ini bertanggung jawab membuat koneksi ke MikroTik dan menjalankan command RouterOS API.

Lokasi file:

```text
app/Services/MikrotikService.php
```

Contoh implementasi:

```php
<?php

namespace App\Services;

use App\Models\MikrotikDevice;
use RouterOS\Client;
use RouterOS\Query;
use Throwable;

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
}
```

---

## 11. Test Data Menggunakan Tinker

Masuk ke container:

```bash
docker exec -it php_laravel bash
```

Jalankan Tinker:

```bash
php artisan tinker
```

Masukkan data contoh:

```php
use App\Models\User;
use App\Models\MikrotikDevice;
use App\Models\ConfigurationTemplate;
use App\Models\DeviceVariable;

$admin = User::query()->first();

$device = MikrotikDevice::updateOrCreate(
    [
        'ip_address' => '192.168.88.1',
        'api_port' => 8728,
    ],
    [
        'name' => 'MTK-LAB-01',
        'username' => 'laravel-api',
        'password' => 'LaravelApi12345',
        'location' => 'Lab MikroTik',
        'description' => 'MikroTik hAP lite untuk testing integrasi Laravel dan RouterOS API.',
        'status' => 'unchecked',
    ]
);

$template = ConfigurationTemplate::updateOrCreate(
    [
        'slug' => 'set-identity-dns-basic',
    ],
    [
        'created_by' => $admin?->id,
        'name' => 'Set Identity dan DNS Basic',
        'category' => 'dns',
        'description' => 'Template aman untuk testing awal. Mengubah identity router dan DNS MikroTik.',
        'script_content' => "/system identity set name={{router_name}}\n/ip dns set servers={{dns_server}} allow-remote-requests=yes",
        'variables' => [
            'router_name',
            'dns_server',
        ],
        'is_active' => true,
    ]
);

$variables = [
    'router_name' => 'MTK-LAB-01',
    'dns_server' => '8.8.8.8,1.1.1.1',
];

foreach ($variables as $key => $value) {
    DeviceVariable::updateOrCreate(
        [
            'mikrotik_device_id' => $device->id,
            'variable_key' => $key,
        ],
        [
            'variable_value' => $value,
            'is_secret' => false,
        ]
    );
}

[
    'device' => $device->fresh()->toArray(),
    'template' => $template->fresh()->toArray(),
    'variables' => $device->variables()->pluck('variable_value', 'variable_key')->toArray(),
];
```

Test koneksi ke MikroTik:

```php
$device = \App\Models\MikrotikDevice::where('ip_address', '192.168.88.1')->first();

$result = app(\App\Services\MikrotikService::class)->testConnection($device);

$result;
```

Contoh hasil berhasil:

```php
[
    "success" => true,
    "message" => "Koneksi ke MikroTik berhasil.",
    "data" => [
        "resource" => [
            "version" => "6.49.9 (stable)",
            "board-name" => "hAP lite",
            "architecture-name" => "smips",
        ],
        "identity" => [
            "name" => "MikroTik",
        ],
    ],
]
```

Cek update device:

```php
$device->fresh()->only([
    'name',
    'ip_address',
    'api_port',
    'username',
    'routeros_version',
    'board_name',
    'architecture_name',
    'status',
    'last_checked_at',
    'last_error',
]);
```

---

## 12. Cara Mengisi Data di Filament

### 12.1 Isi MikroTik Device

Masuk ke:

```text
MikroTik Automation > MikroTik Devices > Create
```

Isi:

```text
Name       : MTK-LAB-01
IP Address : 192.168.88.1
API Port   : 8728
Username   : laravel-api
Password   : LaravelApi12345
Location   : Lab MikroTik
Status     : unchecked
```

Klik Save.

Setelah itu klik action:

```text
Test Connection
```

Jika berhasil, status berubah menjadi `Online`.

### 12.2 Isi Configuration Template

Masuk ke:

```text
MikroTik Automation > Configuration Templates > Create
```

Isi:

```text
Name        : Set Identity dan DNS Basic
Slug        : set-identity-dns-basic
Category    : dns
Description : Template awal untuk mengubah identity dan DNS MikroTik.
```

Script content:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Variables:

```text
router_name
dns_server
```

### 12.3 Isi Device Variables

Masuk ke:

```text
MikroTik Automation > Device Variables > Create
```

Contoh variable pertama:

```text
Device         : MTK-LAB-01
Variable Key   : router_name
Variable Value : MTK-LAB-01
Secret         : false
```

Contoh variable kedua:

```text
Device         : MTK-LAB-01
Variable Key   : dns_server
Variable Value : 8.8.8.8,1.1.1.1
Secret         : false
```

---

## 13. Troubleshooting

### 13.1 Composer Error `ext-sockets` Missing

Error:

```text
requires ext-sockets * but it is not present
```

Solusi:

```dockerfile
docker-php-ext-install sockets
```

Lalu rebuild container:

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

Cek:

```bash
php -m | grep sockets
```

### 13.2 Composer dari Host Error `php: not found`

Error:

```text
/mnt/c/Users/.../composer: php: not found
```

Solusi: jalankan composer dari dalam container.

```bash
docker exec -it php_laravel bash
composer require evilfreelancer/routeros-api-php
```

### 13.3 Filament Resource Tidak Muncul

Pastikan folder resource sesuai dengan struktur starter kit.

Untuk project ini:

```text
app/Filament/Admin/Resources
```

Namespace resource harus:

```php
namespace App\Filament\Admin\Resources\NamaResources;
```

Bukan:

```php
namespace App\Filament\Resources\NamaResources;
```

Pastikan `AdminPanelProvider` memiliki discover path yang benar:

```php
->discoverResources(
    in: app_path('Filament/Admin/Resources'),
    for: 'App\\Filament\\Admin\\Resources',
)
```

Setelah diperbaiki:

```bash
php artisan optimize:clear
composer dump-autoload
```

### 13.4 Tinker Error `Cannot use ... because the name is already in use`

Error ini terjadi karena menjalankan `use App\Models\MikrotikDevice;` lebih dari sekali dalam satu sesi Tinker.

Solusi:

Gunakan langsung full namespace:

```php
$device = \App\Models\MikrotikDevice::where('ip_address', '192.168.88.1')->first();
```

Atau keluar dari Tinker lalu masuk lagi:

```php
exit
```

```bash
php artisan tinker
```

### 13.5 Test Connection Gagal

Cek hal berikut:

1. MikroTik bisa di-ping dari laptop/server Laravel.
2. IP Laravel satu jaringan dengan MikroTik.
3. API MikroTik aktif.
4. Port API adalah `8728`.
5. User `laravel-api` benar.
6. Password benar.
7. Firewall MikroTik tidak memblokir port API.
8. Dari Windows, test:

```powershell
Test-NetConnection 192.168.88.1 -Port 8728
```

Jika `TcpTestSucceeded : True`, berarti port API bisa diakses.

---

## 14. Status Implementasi Saat Ini

Yang sudah berhasil:

- MikroTik memiliki IP `192.168.88.1`.
- Laptop/server Laravel memiliki IP `192.168.88.10`.
- RouterOS API aktif di port `8728`.
- User MikroTik `laravel-api` berhasil dibuat.
- Package RouterOS API digunakan untuk koneksi Laravel ke MikroTik.
- Data device berhasil dibuat melalui Tinker.
- Data template berhasil dibuat melalui Tinker.
- Data variable berhasil dibuat melalui Tinker.
- Laravel berhasil konek ke MikroTik via `MikrotikService`.
- Response MikroTik berhasil terbaca:
  - RouterOS `6.49.9 (stable)`
  - Board `hAP lite`
  - Architecture `smips`

---

## 15. Rencana Pengembangan Berikutnya

Tahap berikutnya yang disarankan:

1. Membuat `TemplateParserService`.
2. Membuat fitur replace placeholder `{{variable}}`.
3. Membuat preview generated command di Filament.
4. Membuat `DeploymentService`.
5. Membuat deployment ke satu perangkat.
6. Menyimpan log ke tabel `deployments` dan `deployment_details`.
7. Membuat deployment massal.
8. Menggunakan Laravel Queue untuk bulk deployment.
9. Membuat fitur backup konfigurasi.
10. Membuat dashboard statistik berhasil/gagal.
11. Membuat laporan deployment.
12. Membandingkan waktu konfigurasi manual dan otomatis untuk kebutuhan tugas akhir.

---

## 16. Contoh Template Aman untuk Testing

### 16.1 Set Identity dan DNS

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

### 16.2 Set DNS Saja

```mikrotik
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

### 16.3 Set Identity Saja

```mikrotik
/system identity set name={{router_name}}
```

### 16.4 NAT Basic

```mikrotik
/ip firewall nat add chain=srcnat out-interface={{wan_interface}} action=masquerade
```

### 16.5 IP Address

```mikrotik
/ip address add address={{ip_address}} interface={{interface}}
```

---

## 17. Catatan Keamanan

Walaupun project ini digunakan untuk belajar dan tugas akhir, beberapa prinsip keamanan tetap disarankan:

1. Jangan memakai user `admin` MikroTik untuk Laravel.
2. Gunakan user khusus seperti `laravel-api`.
3. Simpan password MikroTik dengan cast `encrypted`.
4. Batasi akses API hanya dari jaringan Laravel jika memungkinkan.
5. Gunakan preview sebelum deployment.
6. Jangan menjalankan template yang belum diuji.
7. Untuk produksi, pertimbangkan API-SSL port `8729`.
8. Selalu simpan log deployment.

---

## 18. Ringkasan Singkat

Project ini bekerja dengan konsep berikut:

```text
MikroTik Device
    ↓
Disimpan di Laravel
    ↓
Dikelola melalui Filament
    ↓
Laravel melakukan Test Connection via RouterOS API
    ↓
Admin membuat Configuration Template
    ↓
Admin mengisi Device Variables
    ↓
Sistem menghasilkan command final
    ↓
Laravel mengirim command ke MikroTik
    ↓
Hasil deployment disimpan sebagai log
```

Dengan alur ini, konfigurasi MikroTik yang biasanya dilakukan manual melalui WinBox atau terminal dapat dilakukan secara otomatis, terpusat, dan terdokumentasi melalui web.

---

## 19. Lisensi

Project ini dibuat untuk kebutuhan pembelajaran, penelitian, dan tugas akhir.

---

## 20. Author

Dikembangkan sebagai project tugas akhir sistem otomatisasi konfigurasi MikroTik berbasis web menggunakan Laravel, Filament, dan RouterOS API.
