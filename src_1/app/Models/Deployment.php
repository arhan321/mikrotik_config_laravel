<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Deployment extends Model
{
    use HasFactory;

    protected $table = 'deployments';

    protected $fillable = [
        'deployment_code',
        'configuration_template_id',
        'user_id',
        'mode',
        'status',
        'total_devices',
        'success_count',
        'failed_count',
        'started_at',
        'finished_at',
        'duration_ms',
        'notes',
    ];

    protected $casts = [
        'total_devices' => 'integer',
        'success_count' => 'integer',
        'failed_count' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'duration_ms' => 'integer',
    ];

    /**
     * Template konfigurasi yang digunakan deployment ini.
     */
    public function configurationTemplate(): BelongsTo
    {
        return $this->belongsTo(ConfigurationTemplate::class, 'configuration_template_id');
    }

    /**
     * User yang menjalankan deployment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Detail device yang diproses dalam deployment ini.
     */
    public function details(): HasMany
    {
        return $this->hasMany(DeploymentDetail::class, 'deployment_id');
    }
}
