<?php

namespace App\Models;

use App\Models\MikrotikDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceVariable extends Model
{
    use HasFactory;

    protected $table = 'device_variables';

    protected $fillable = [
        'mikrotik_device_id',
        'variable_key',
        'variable_value',
        'is_secret',
    ];

    protected $casts = [
        'is_secret' => 'boolean',
    ];

    /**
     * Device MikroTik pemilik variable ini.
     */
    public function mikrotikDevice(): BelongsTo
    {
        return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
    }
}