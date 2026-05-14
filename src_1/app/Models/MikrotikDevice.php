<?php

namespace App\Models;

use App\Models\DeviceVariable;
use App\Models\MikrotikBackup;
use App\Models\DeploymentDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MikrotikDevice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mikrotik_devices';

    protected $fillable = [
        'name',
        'ip_address',
        'api_port',
        'username',
        'password',
        'location',
        'description',
        'routeros_version',
        'board_name',
        'architecture_name',
        'status',
        'last_checked_at',
        'last_error',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'api_port' => 'integer',
        'password' => 'encrypted',
        'last_checked_at' => 'datetime',
    ];

    /**
     * Variable milik device MikroTik.
     */
    public function variables(): HasMany
    {
        return $this->hasMany(DeviceVariable::class, 'mikrotik_device_id');
    }

    /**
     * Detail deployment yang pernah dijalankan ke device ini.
     */
    public function deploymentDetails(): HasMany
    {
        return $this->hasMany(DeploymentDetail::class, 'mikrotik_device_id');
    }

    /**
     * Backup dari device ini.
     */
    public function backups(): HasMany
    {
        return $this->hasMany(MikrotikBackup::class, 'mikrotik_device_id');
    }
}