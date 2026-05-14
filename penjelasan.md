# Penjelasan Project Laravel + Filament + MikroTik RouterOS API

## 1. Gambaran Umum Project

Project ini adalah sistem berbasis web untuk membantu administrator jaringan melakukan pengelolaan dan konfigurasi perangkat MikroTik melalui aplikasi Laravel. Sistem dibangun menggunakan Laravel sebagai backend, Filament sebagai panel admin, MySQL sebagai database, dan RouterOS API sebagai jalur komunikasi antara aplikasi web dengan perangkat MikroTik.

Secara sederhana, sistem ini dibuat supaya admin tidak harus selalu membuka WinBox atau terminal MikroTik untuk melakukan konfigurasi dasar. Admin dapat masuk ke panel Filament, memilih perangkat MikroTik yang sudah terdaftar, lalu melakukan beberapa aksi seperti:

- melihat dan mengelola data perangkat MikroTik;
- melakukan test connection ke perangkat MikroTik;
- melihat informasi RouterOS, board, dan architecture perangkat;
- membuat template konfigurasi;
- mengisi variable konfigurasi untuk setiap perangkat;
- membaca daftar interface langsung dari MikroTik;
- membaca daftar IP address langsung dari MikroTik;
- menambahkan IP address ke interface tertentu;
- menghapus IP address non-dynamic;
- menyiapkan fondasi deployment konfigurasi otomatis;
- menyiapkan fondasi backup dan log hasil deployment.

Topik ini mengarah ke sistem **Network Automation** atau otomasi jaringan, yaitu proses mengelola konfigurasi perangkat jaringan melalui aplikasi, bukan secara manual satu per satu.

---

## 2. Judul Project

Judul yang dapat digunakan:

> **Rancang Bangun Sistem Otomatisasi Konfigurasi Perangkat MikroTik Berbasis Web Menggunakan Laravel, Filament, dan RouterOS API**

Alternatif judul:

1. Sistem Otomatisasi Konfigurasi MikroTik Berbasis Web Menggunakan Laravel dan RouterOS API
2. Implementasi Network Automation untuk Konfigurasi Massal Perangkat MikroTik Berbasis Laravel
3. Sistem Manajemen Konfigurasi MikroTik Berbasis Template Menggunakan Filament
4. Pengembangan Sistem Otomatisasi Router MikroTik Menggunakan Laravel dan RouterOS API

---

## 3. Tujuan Sistem

Tujuan utama sistem ini adalah membuat aplikasi yang dapat membantu admin jaringan dalam mengelola konfigurasi MikroTik secara lebih cepat, terpusat, dan terdokumentasi.

Tujuan detailnya:

1. Membuat sistem berbasis web untuk mengelola perangkat MikroTik.
2. Menghubungkan Laravel dengan MikroTik menggunakan RouterOS API.
3. Menyediakan panel admin berbasis Filament.
4. Menyimpan data perangkat MikroTik seperti IP, port API, username, password, lokasi, dan status koneksi.
5. Melakukan test connection ke perangkat MikroTik.
6. Membaca informasi RouterOS dari perangkat secara langsung.
7. Menyediakan fitur manajemen template konfigurasi MikroTik.
8. Menyediakan fitur variable konfigurasi per perangkat.
9. Menyiapkan proses deployment konfigurasi otomatis.
10. Menyediakan fitur IP Address Manager sebagai bukti konfigurasi langsung dari web ke MikroTik.
11. Menyiapkan fondasi log deployment dan backup konfigurasi.

---

## 4. Teknologi yang Digunakan

Project ini menggunakan beberapa teknologi utama:

| Komponen | Teknologi |
|---|---|
| Backend | Laravel |
| Admin Panel | Filament |
| Database | MySQL / MariaDB |
| API MikroTik | RouterOS API |
| Library RouterOS PHP | `evilfreelancer/routeros-api-php` |
| Container | Docker |
| PHP | PHP 8.x |
| UI tambahan | Blade + Livewire / Filament Page |
| Sistem Login | Fila Starter / Filament Auth |
| Role & Permission | Spatie Permission / Filament Shield jika tersedia |

---

## 5. Arsitektur Sistem

Arsitektur sistem dapat digambarkan seperti ini:

```text
User / Admin
    ↓
Web Browser
    ↓
Laravel Application
    ↓
Filament Admin Panel
    ↓
Service Layer
    ↓
RouterOS API Client
    ↓
MikroTik RouterOS Device
```

Penjelasan:

1. **User/Admin** membuka panel admin melalui browser.
2. **Filament Panel** digunakan sebagai antarmuka CRUD dan tools konfigurasi.
3. **Laravel** mengelola validasi, database, model, service, dan proses bisnis.
4. **Service Layer** seperti `MikrotikService` bertugas menghubungkan Laravel ke MikroTik.
5. **RouterOS API Client** mengirim perintah ke perangkat MikroTik.
6. **MikroTik RouterOS** menerima command dan mengembalikan response ke Laravel.
7. Laravel menyimpan hasilnya ke database, misalnya status koneksi, log deployment, atau informasi perangkat.

---

## 6. Kondisi Sistem Saat Ini

Sistem yang sudah dibuat saat ini sudah memiliki pondasi utama sebagai berikut:

### 6.1 Panel Admin Filament

Panel admin sudah berjalan di:

```text
/admin
```

Menu yang sudah muncul:

```text
MikroTik Automation
├── MikroTik Devices
├── Configuration Templates
├── Device Variables
├── Deployments
├── Deployment Details
├── MikroTik Backups
└── IP Address Manager

Administration
├── Users
├── Roles & Permissions
└── Activity Log
```

### 6.2 Koneksi Laravel ke MikroTik

Laravel sudah berhasil melakukan koneksi ke MikroTik menggunakan data:

```text
IP MikroTik : 192.168.88.1
Port API    : 8728
Username    : laravel-api
Password    : LaravelApi12345
```

Dari hasil test Tinker, Laravel berhasil membaca informasi perangkat MikroTik seperti:

```text
RouterOS Version : 6.49.9 (stable)
Board Name       : hAP lite
Architecture     : smips
Identity         : MikroTik
```

Artinya integrasi Laravel dengan RouterOS API sudah berhasil.

### 6.3 IP Address Manager

Fitur tambahan yang sudah dibuat adalah **IP Address Manager**.

Fitur ini memungkinkan admin:

1. memilih perangkat MikroTik;
2. membaca interface langsung dari MikroTik;
3. membaca daftar IP address langsung dari MikroTik;
4. menambahkan IP address baru ke interface tertentu;
5. menghapus IP address yang tidak dynamic.

Contoh aksi yang sudah bisa dilakukan:

```text
Tambah IP:
address   = 192.168.20.1/24
interface = ether2
comment   = Added from Filament
```

Command RouterOS yang dijalankan di belakang layar:

```mikrotik
/ip address add address=192.168.20.1/24 interface=ether2 comment="Added from Filament"
```

---

## 7. Setup MikroTik yang Digunakan

MikroTik sudah dikonfigurasi agar bisa diakses dari Laravel.

### 7.1 IP Address MikroTik

MikroTik diberi IP pada `ether1`:

```mikrotik
/ip address add address=192.168.88.1/24 interface=ether1 comment="LAN Laravel"
```

Laptop/server Laravel berada di jaringan yang sama:

```text
Laptop / Laravel : 192.168.88.10
MikroTik         : 192.168.88.1
Subnet           : 255.255.255.0
```

### 7.2 RouterOS API

RouterOS API diaktifkan pada port `8728`:

```mikrotik
/ip service enable api
/ip service set api port=8728
/ip service set api address=192.168.88.0/24
```

### 7.3 User Khusus Laravel

User khusus dibuat agar Laravel tidak menggunakan user admin utama:

```mikrotik
/user group add name=laravel-api policy=read,write,api,test,sensitive
/user add name=laravel-api password="LaravelApi12345" group=laravel-api
```

Data ini kemudian disimpan di tabel `mikrotik_devices`.

---

## 8. Struktur Database

Database dibuat untuk mendukung kebutuhan otomasi konfigurasi MikroTik.

### 8.1 Tabel `mikrotik_devices`

Tabel ini menyimpan data perangkat MikroTik.

Field penting:

| Field | Fungsi |
|---|---|
| `id` | ID perangkat |
| `name` | Nama perangkat |
| `ip_address` | IP MikroTik |
| `api_port` | Port RouterOS API |
| `username` | Username MikroTik |
| `password` | Password MikroTik terenkripsi |
| `location` | Lokasi perangkat |
| `description` | Keterangan perangkat |
| `routeros_version` | Versi RouterOS |
| `board_name` | Nama board MikroTik |
| `architecture_name` | Arsitektur perangkat |
| `status` | Status koneksi |
| `last_checked_at` | Waktu terakhir test connection |
| `last_error` | Error terakhir jika gagal koneksi |

Model:

```php
App\Models\MikrotikDevice
```

Relasi:

```php
variables()
deploymentDetails()
backups()
```

Catatan keamanan:

```php
protected $casts = [
    'api_port' => 'integer',
    'password' => 'encrypted',
    'last_checked_at' => 'datetime',
];
```

Dengan cast `encrypted`, password MikroTik tidak disimpan dalam bentuk plaintext.

---

### 8.2 Tabel `configuration_templates`

Tabel ini menyimpan template command konfigurasi MikroTik.

Field penting:

| Field | Fungsi |
|---|---|
| `id` | ID template |
| `created_by` | User pembuat template |
| `name` | Nama template |
| `slug` | Slug unik |
| `category` | Kategori template |
| `description` | Deskripsi template |
| `script_content` | Isi command MikroTik |
| `variables` | Daftar variable yang dipakai |
| `is_active` | Status aktif template |

Contoh template:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Model:

```php
App\Models\ConfigurationTemplate
```

Relasi:

```php
creator()
deployments()
```

---

### 8.3 Tabel `device_variables`

Tabel ini menyimpan nilai variable untuk setiap perangkat.

Field penting:

| Field | Fungsi |
|---|---|
| `id` | ID variable |
| `mikrotik_device_id` | Device pemilik variable |
| `variable_key` | Nama variable |
| `variable_value` | Nilai variable |
| `is_secret` | Penanda data sensitif |

Contoh data:

```text
router_name = MTK-LAB-01
dns_server  = 8.8.8.8,1.1.1.1
interface   = ether2
ip_address  = 192.168.20.1/24
```

Model:

```php
App\Models\DeviceVariable
```

Relasi:

```php
mikrotikDevice()
```

---

### 8.4 Tabel `deployments`

Tabel ini menyimpan data deployment utama.

Field penting:

| Field | Fungsi |
|---|---|
| `deployment_code` | Kode deployment |
| `configuration_template_id` | Template yang digunakan |
| `user_id` | User yang menjalankan |
| `mode` | Single atau bulk |
| `status` | Pending, running, success, failed |
| `total_devices` | Jumlah target perangkat |
| `success_count` | Jumlah berhasil |
| `failed_count` | Jumlah gagal |
| `started_at` | Waktu mulai |
| `finished_at` | Waktu selesai |
| `duration_ms` | Durasi proses |

Model:

```php
App\Models\Deployment
```

Relasi:

```php
configurationTemplate()
user()
details()
```

Saat ini tabel ini sudah tersedia sebagai pondasi, tetapi proses deployment otomatis masih perlu dikembangkan lebih lanjut.

---

### 8.5 Tabel `deployment_details`

Tabel ini menyimpan detail deployment per perangkat.

Field penting:

| Field | Fungsi |
|---|---|
| `deployment_id` | ID deployment utama |
| `mikrotik_device_id` | Device target |
| `status` | Status per device |
| `command_sent` | Command final yang dikirim |
| `response_message` | Response dari MikroTik |
| `error_message` | Error jika gagal |
| `started_at` | Waktu mulai |
| `finished_at` | Waktu selesai |
| `duration_ms` | Durasi proses |

Model:

```php
App\Models\DeploymentDetail
```

Relasi:

```php
deployment()
mikrotikDevice()
```

---

### 8.6 Tabel `mikrotik_backups`

Tabel ini disiapkan untuk fitur backup konfigurasi MikroTik.

Field penting:

| Field | Fungsi |
|---|---|
| `mikrotik_device_id` | Device yang dibackup |
| `created_by` | User pembuat backup |
| `backup_name` | Nama backup |
| `backup_type` | Export atau backup |
| `status` | Status backup |
| `backup_path` | Lokasi file backup |
| `backup_content` | Isi backup jika disimpan ke DB |
| `file_size` | Ukuran file |
| `error_message` | Error jika gagal |

Model:

```php
App\Models\MikrotikBackup
```

Relasi:

```php
mikrotikDevice()
creator()
```

---

## 9. Penjelasan Menu Filament

### 9.1 MikroTik Devices

Menu ini digunakan untuk mengelola data perangkat MikroTik.

Fungsi:

- tambah device;
- edit device;
- hapus device;
- menyimpan IP, port API, username, password;
- menyimpan status koneksi;
- melihat versi RouterOS;
- melihat board dan architecture;
- melihat waktu terakhir pengecekan;
- melakukan test connection.

Contoh data:

```text
Name       : MTK-LAB-01
IP Address : 192.168.88.1
API Port   : 8728
Username   : laravel-api
Password   : LaravelApi12345
Location   : Lab MikroTik
```

---

### 9.2 Configuration Templates

Menu ini digunakan untuk membuat template command MikroTik.

Contoh template:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Variable yang digunakan:

```text
router_name
dns_server
```

Fungsi menu ini:

- membuat template;
- mengubah template;
- menghapus template;
- mengelompokkan template berdasarkan kategori;
- menyimpan daftar variable;
- menjadi dasar deployment konfigurasi.

---

### 9.3 Device Variables

Menu ini digunakan untuk mengisi nilai variable untuk setiap perangkat MikroTik.

Contoh:

```text
Device: MTK-LAB-01

router_name = MTK-LAB-01
dns_server  = 8.8.8.8,1.1.1.1
```

Konsepnya:

```text
Template:
    /system identity set name={{router_name}}

Variable:
    router_name = MTK-LAB-01

Hasil:
    /system identity set name=MTK-LAB-01
```

---

### 9.4 Deployments

Menu ini disiapkan untuk mencatat proses deployment konfigurasi.

Saat ini fungsinya masih berupa CRUD data deployment.

Nantinya menu ini akan menjadi tempat:

1. memilih template;
2. memilih satu atau banyak device;
3. melihat preview command;
4. menjalankan deployment;
5. melihat hasil sukses atau gagal;
6. melihat rekap deployment.

---

### 9.5 Deployment Details

Menu ini digunakan untuk melihat detail deployment per perangkat.

Nantinya setiap deployment akan punya beberapa detail, misalnya:

```text
Deployment: DPLY-202605140001

Device 1: MTK-LAB-01
Status : success
Command: /system identity set name=MTK-LAB-01

Device 2: MTK-CABANG-02
Status : failed
Error  : connection timeout
```

---

### 9.6 MikroTik Backups

Menu ini disiapkan untuk backup konfigurasi MikroTik.

Backup dapat menggunakan command:

```mikrotik
/export file={{export_name}}
```

atau:

```mikrotik
/system backup save name={{backup_name}}
```

Saat ini menu backup masih berupa struktur CRUD. Proses backup langsung dari RouterOS API masih dapat dikembangkan pada tahap berikutnya.

---

### 9.7 IP Address Manager

Menu ini adalah custom Filament Page, bukan resource CRUD biasa.

Fungsi:

- memilih device MikroTik;
- membaca interface dari MikroTik;
- membaca daftar IP address dari MikroTik;
- menambahkan IP address;
- menghapus IP address non-dynamic.

Data IP address yang muncul di halaman ini **bukan dari database lokal**, melainkan langsung dari MikroTik melalui RouterOS API.

Contoh proses tambah IP:

```text
Input:
Address   : 192.168.20.1/24
Interface : ether2
Comment   : Added from Filament

RouterOS API Command:
/ip address add address=192.168.20.1/24 interface=ether2 comment="Added from Filament"
```

---

## 10. Penjelasan `MikrotikService`

`MikrotikService` adalah bagian penting dalam sistem. Service ini menjadi penghubung antara Laravel dan perangkat MikroTik.

Lokasi file:

```text
app/Services/MikrotikService.php
```

Fungsi utama:

1. membuat koneksi ke MikroTik;
2. test connection;
3. membaca resource perangkat;
4. membaca identity perangkat;
5. membaca daftar interface;
6. membaca daftar IP address;
7. menambahkan IP address;
8. menghapus IP address.

### 10.1 Membuat Client RouterOS

Method:

```php
makeClient(MikrotikDevice $device)
```

Fungsi:

- membaca IP address dari database;
- membaca username dan password;
- membaca port API;
- membuat object RouterOS Client.

Konsep:

```php
new Client([
    'host' => $device->ip_address,
    'user' => $device->username,
    'pass' => $device->password,
    'port' => (int) $device->api_port,
]);
```

---

### 10.2 Test Connection

Method:

```php
testConnection(MikrotikDevice $device)
```

Fungsi:

1. membuka koneksi ke MikroTik;
2. menjalankan command:

```mikrotik
/system/resource/print
/system/identity/print
```

3. menyimpan hasil ke database:
   - `routeros_version`;
   - `board_name`;
   - `architecture_name`;
   - `status`;
   - `last_checked_at`;
   - `last_error`.

Jika berhasil:

```text
status = online
last_error = null
```

Jika gagal:

```text
status = offline
last_error = pesan error
```

---

### 10.3 Membaca Interface

Method:

```php
getInterfaces(MikrotikDevice $device)
```

Command RouterOS:

```mikrotik
/interface/print
```

Data yang dibaca:

- name;
- type;
- mac-address;
- running;
- disabled.

Contoh output:

```text
ether1  running
ether2  idle
ether3  idle
ether4  idle
wlan1   disabled
```

---

### 10.4 Membaca IP Address

Method:

```php
getIpAddresses(MikrotikDevice $device)
```

Command RouterOS:

```mikrotik
/ip/address/print
```

Data yang dibaca:

- address;
- network;
- interface;
- comment;
- dynamic;
- disabled;
- id RouterOS.

Contoh output:

```text
192.168.88.1/24   ether1   LAN Laravel
192.168.20.1/24   ether2   Added from Laravel Tinker
```

---

### 10.5 Menambahkan IP Address

Method:

```php
addIpAddress(
    MikrotikDevice $device,
    string $address,
    string $interface,
    ?string $comment = null
)
```

Command RouterOS:

```mikrotik
/ip/address/add
```

Contoh:

```php
app(\App\Services\MikrotikService::class)->addIpAddress(
    device: $device,
    address: '192.168.20.1/24',
    interface: 'ether2',
    comment: 'Added from Filament'
);
```

Hasil di MikroTik:

```mikrotik
/ip address print
```

```text
192.168.20.1/24 interface=ether2 comment="Added from Filament"
```

---

### 10.6 Menghapus IP Address

Method:

```php
removeIpAddress(MikrotikDevice $device, string $id)
```

Command RouterOS:

```mikrotik
/ip/address/remove
```

Catatan:

- IP dynamic tidak disarankan untuk dihapus.
- IP yang sedang dipakai Laravel untuk koneksi tidak boleh dihapus.
- Jika IP `192.168.88.1/24` di `ether1` dihapus, Laravel bisa putus koneksi dari MikroTik.

---

## 11. Alur Kerja Test Connection

Alur kerja fitur test connection:

```text
Admin membuka MikroTik Devices
    ↓
Admin memilih device
    ↓
Admin klik Test Connection
    ↓
Laravel membaca data device dari database
    ↓
MikrotikService membuat RouterOS Client
    ↓
Laravel konek ke 192.168.88.1:8728
    ↓
Laravel menjalankan /system/resource/print
    ↓
Laravel menjalankan /system/identity/print
    ↓
Laravel menyimpan hasil ke database
    ↓
Filament menampilkan notifikasi berhasil/gagal
```

Jika berhasil, device akan berubah menjadi:

```text
status = online
routeros_version = 6.49.9 (stable)
board_name = hAP lite
architecture_name = smips
last_checked_at = waktu sekarang
last_error = null
```

---

## 12. Alur Kerja IP Address Manager

Alur kerja halaman IP Address Manager:

```text
Admin membuka IP Address Manager
    ↓
Admin memilih MikroTik Device
    ↓
Admin klik Refresh Data
    ↓
Laravel membaca interface dari MikroTik
    ↓
Laravel membaca IP address dari MikroTik
    ↓
Data ditampilkan di halaman Filament
```

Untuk tambah IP:

```text
Admin mengisi address, interface, comment
    ↓
Admin klik Tambahkan IP Address
    ↓
Laravel validasi input
    ↓
Laravel mengirim command /ip/address/add
    ↓
MikroTik menambahkan IP ke interface
    ↓
Laravel refresh data
    ↓
IP baru muncul di tabel
```

Untuk hapus IP:

```text
Admin klik tombol Hapus
    ↓
Konfirmasi penghapusan
    ↓
Laravel mengirim command /ip/address/remove
    ↓
MikroTik menghapus IP
    ↓
Laravel refresh data
```

---

## 13. Contoh Data Tinker

Data awal dapat dibuat melalui Tinker:

```bash
php artisan tinker
```

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
```

Test koneksi:

```php
$device = \App\Models\MikrotikDevice::where('ip_address', '192.168.88.1')->first();

app(\App\Services\MikrotikService::class)->testConnection($device);
```

---

## 14. Mapping BRD dengan Implementasi Saat Ini

| Kebutuhan BRD | Status Saat Ini | Keterangan |
|---|---|---|
| Login dan autentikasi | Sudah | Disediakan oleh Fila Starter / Filament |
| Manajemen user | Sudah | Ada menu Users |
| Role dan permission | Sudah dasar | Ada Roles & Permissions |
| Dashboard | Sebagian | Masih dashboard starter, belum dashboard MikroTik khusus |
| Manajemen perangkat MikroTik | Sudah | Ada resource MikroTik Devices |
| Test connection | Sudah | Berhasil lewat Tinker dan siap di Filament |
| Template konfigurasi | Sudah struktur | Ada resource Configuration Templates |
| Variable perangkat | Sudah struktur | Ada resource Device Variables |
| Deployment satu perangkat | Belum penuh | Tabel ada, engine belum selesai |
| Deployment massal | Belum | Perlu queue/job |
| Deployment details | Sudah struktur | Tabel dan resource ada |
| Backup konfigurasi | Belum penuh | Tabel dan resource ada, logic belum selesai |
| Log aktivitas | Sebagian | Starter sudah punya Activity Log |
| Laporan deployment | Belum | Perlu report/filter/export |
| IP Address Manager | Sudah | Fitur tambahan untuk konfigurasi IP langsung |

---

## 15. Fitur yang Sudah Bisa Didemokan

Saat ini fitur yang sudah bisa didemokan adalah:

1. Login admin ke Filament.
2. Melihat menu MikroTik Automation.
3. Menambahkan data perangkat MikroTik.
4. Menyimpan password MikroTik secara terenkripsi.
5. Melakukan test connection ke MikroTik.
6. Membaca RouterOS version, board, dan architecture.
7. Membuat template konfigurasi identity dan DNS.
8. Mengisi variable `router_name` dan `dns_server`.
9. Membuka IP Address Manager.
10. Membaca interface MikroTik langsung dari router.
11. Membaca IP address MikroTik langsung dari router.
12. Menambahkan IP address ke `ether2`.
13. Menghapus IP address non-dynamic.
14. Membuktikan Laravel dapat mengubah konfigurasi MikroTik melalui RouterOS API.

---

## 16. Fitur yang Belum Selesai dan Perlu Dilanjutkan

Agar sistem sesuai BRD secara penuh, bagian berikut masih perlu dikerjakan:

### 16.1 Template Parser Service

Service ini bertugas mengganti placeholder dengan variable.

Contoh:

```mikrotik
/system identity set name={{router_name}}
```

Menjadi:

```mikrotik
/system identity set name=MTK-LAB-01
```

### 16.2 Deployment Service

Service ini bertugas menjalankan template ke satu atau banyak MikroTik.

Alur:

```text
Pilih template
Pilih device
Ambil variable device
Generate command
Kirim ke MikroTik
Simpan deployments
Simpan deployment_details
Tampilkan hasil
```

### 16.3 Preview Generated Configuration

Sebelum command dikirim, sistem harus menampilkan preview agar admin bisa memastikan konfigurasi benar.

Contoh preview:

```mikrotik
/system identity set name=MTK-LAB-01
/ip dns set servers=8.8.8.8,1.1.1.1 allow-remote-requests=yes
```

### 16.4 Deployment Massal

Untuk banyak perangkat, deployment sebaiknya menggunakan queue.

Alur:

```text
Deployment dibuat
Job dikirim ke queue
Setiap device diproses satu per satu
Jika satu gagal, device lain tetap diproses
Hasil disimpan per device
```

### 16.5 Backup Otomatis

Fitur backup dapat menggunakan:

```mikrotik
/export file={{export_name}}
```

atau:

```mikrotik
/system backup save name={{backup_name}}
```

Sistem perlu menyimpan hasil backup ke storage Laravel atau database.

### 16.6 Dashboard Statistik

Dashboard khusus MikroTik dapat menampilkan:

- jumlah device;
- device online;
- device offline;
- total deployment;
- deployment berhasil;
- deployment gagal;
- aktivitas terbaru;
- grafik keberhasilan deployment.

---

## 17. Flow Deployment yang Disarankan

Flow deployment yang ideal:

```text
Admin
    ↓
Buka menu Deployments
    ↓
Pilih Configuration Template
    ↓
Pilih MikroTik Device
    ↓
Sistem mengambil Device Variables
    ↓
Sistem mengganti placeholder
    ↓
Sistem menampilkan preview command
    ↓
Admin konfirmasi
    ↓
Sistem mengirim command via RouterOS API
    ↓
Sistem menyimpan deployment log
    ↓
Sistem menampilkan status sukses/gagal
```

Contoh template:

```mikrotik
/system identity set name={{router_name}}
/ip dns set servers={{dns_server}} allow-remote-requests=yes
```

Variable:

```text
router_name = MTK-LAB-01
dns_server = 8.8.8.8,1.1.1.1
```

Generated command:

```mikrotik
/system identity set name=MTK-LAB-01
/ip dns set servers=8.8.8.8,1.1.1.1 allow-remote-requests=yes
```

---

## 18. Keamanan Sistem

Beberapa hal keamanan yang sudah dan perlu diperhatikan:

### 18.1 Password MikroTik

Password perangkat MikroTik harus disimpan terenkripsi:

```php
'password' => 'encrypted'
```

Jangan simpan password dalam plaintext.

### 18.2 User MikroTik Khusus Laravel

Laravel sebaiknya memakai user khusus:

```text
username = laravel-api
```

Bukan user admin utama.

### 18.3 Batasi API

RouterOS API sebaiknya hanya boleh diakses dari jaringan tertentu:

```mikrotik
/ip service set api address=192.168.88.0/24
```

### 18.4 Hindari Menghapus IP Aktif

Jangan menghapus IP yang dipakai Laravel untuk koneksi:

```text
192.168.88.1/24 di ether1
```

Jika IP ini dihapus, Laravel bisa kehilangan koneksi ke MikroTik.

### 18.5 Preview Sebelum Deployment

Sebelum deployment, wajib tampilkan preview command agar admin tidak salah kirim konfigurasi.

---

## 19. Troubleshooting

### 19.1 Laravel Tidak Bisa Connect ke MikroTik

Cek dari Windows:

```powershell
ping 192.168.88.1
Test-NetConnection 192.168.88.1 -Port 8728
```

Jika `TcpTestSucceeded: True`, jaringan dan port API sudah bisa diakses.

### 19.2 Composer Gagal Install RouterOS API

Jika muncul error:

```text
requires ext-sockets
```

Tambahkan extension sockets pada Dockerfile:

```dockerfile
docker-php-ext-install sockets
```

Lalu rebuild:

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

Cek:

```bash
php -m | grep sockets
```

### 19.3 Filament Resource Tidak Muncul

Pastikan resource berada di:

```text
app/Filament/Admin/Resources
```

Namespace harus:

```php
App\Filament\Admin\Resources
```

Pastikan `AdminPanelProvider` discover resource dari path yang benar:

```php
->discoverResources(
    in: app_path('Filament/Admin/Resources'),
    for: 'App\\Filament\\Admin\\Resources',
)
```

### 19.4 Error Action::make()

Jika muncul:

```text
Call to undefined method Illuminate\Notifications\Action::make()
```

Berarti import salah.

Yang benar:

```php
use Filament\Actions\Action;
use Filament\Notifications\Notification;
```

Bukan:

```php
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Notification;
```

### 19.5 Tinker Error `Cannot use ... because the name is already in use`

Itu terjadi karena `use App\Models\MikrotikDevice;` dipanggil dua kali dalam satu session Tinker.

Solusi:

```php
$device = \App\Models\MikrotikDevice::where('ip_address', '192.168.88.1')->first();
```

atau keluar dari Tinker lalu masuk lagi.

---

## 20. Rekomendasi Urutan Pengembangan Berikutnya

Urutan yang paling disarankan:

1. Rapikan IP Address Manager.
2. Buat `TemplateParserService`.
3. Buat preview generated configuration.
4. Buat `DeploymentService`.
5. Integrasikan deployment ke menu Deployments.
6. Simpan log ke `deployment_details`.
7. Buat deployment massal.
8. Tambahkan queue untuk proses massal.
9. Buat backup configuration.
10. Buat dashboard statistik MikroTik.
11. Buat laporan deployment.
12. Tambahkan export PDF/Excel jika diperlukan.

---

## 21. Kesimpulan

Project Laravel + Filament + MikroTik ini sudah berada pada tahap integrasi nyata. Sistem tidak hanya memiliki CRUD database, tetapi sudah berhasil berkomunikasi langsung dengan perangkat MikroTik menggunakan RouterOS API.

Fitur yang sudah terbukti berjalan adalah koneksi Laravel ke MikroTik, pembacaan data RouterOS, pembacaan interface, pembacaan IP address, penambahan IP address, dan penghapusan IP address melalui panel Filament.

Namun, untuk memenuhi BRD secara penuh, bagian yang perlu difokuskan berikutnya adalah **Deployment Engine**, yaitu fitur yang dapat mengambil template, mengganti variable, menampilkan preview, mengirim command ke MikroTik, lalu menyimpan hasilnya ke log deployment.

Dengan menyelesaikan deployment engine, sistem ini akan benar-benar sesuai dengan konsep utama tugas akhir, yaitu:

> **otomatisasi konfigurasi perangkat MikroTik berbasis web menggunakan Laravel, Filament, dan RouterOS API.**
