<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DeploymentDetail extends Model
{
    use HasFactory;

    protected $table = 'deployment_details';

    protected $fillable = [
        'deployment_id',
        'mikrotik_device_id',
        'status',
        'command_sent',
        'response_message',
        'error_message',
        'started_at',
        'finished_at',
        'duration_ms',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'duration_ms' => 'integer',
    ];

    /**
     * Deployment utama.
     */
    public function deployment(): BelongsTo
    {
        return $this->belongsTo(Deployment::class, 'deployment_id');
    }

    /**
     * Device MikroTik yang diproses.
     */
    public function mikrotikDevice(): BelongsTo
    {
        return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
    }
}
