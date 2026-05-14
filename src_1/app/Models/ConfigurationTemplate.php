<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ConfigurationTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'configuration_templates';

    protected $fillable = [
        'created_by',
        'name',
        'slug',
        'category',
        'description',
        'script_content',
        'variables',
        'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * User pembuat template.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Deployment yang menggunakan template ini.
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class, 'configuration_template_id');
    }
}
