<?php

namespace App\Models;

use App\Models\User;
use App\Models\MikrotikDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MikrotikBackup extends Model
{
    use HasFactory;

    protected $table = 'mikrotik_backups';

    protected $fillable = [
        'mikrotik_device_id',
        'created_by',
        'backup_name',
        'backup_type',
        'status',
        'backup_path',
        'backup_content',
        'file_size',
        'error_message',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    /**
     * Device MikroTik yang di-backup.
     */
    public function mikrotikDevice(): BelongsTo
    {
        return $this->belongsTo(MikrotikDevice::class, 'mikrotik_device_id');
    }

    /**
     * User pembuat backup.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}