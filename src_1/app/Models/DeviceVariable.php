<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DeviceVariable extends Model
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
