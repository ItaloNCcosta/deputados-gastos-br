<?php

declare(strict_types=1);

namespace Modules\ParliamentaryGroup\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ParliamentaryGroupStatus\Models\ParliamentaryGroupStatus;
use Modules\ParliamentaryGroupStatusDetail\Models\ParliamentaryGroupStatusDetail;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'creation_year',
        'is_active',
        'is_mixed_group',
        'name',
        'notes',
        'project_title',
        'project_uri',
        'resolution_title',
        'resolution_uri',
        'is_subsidized',
        'resource_uri',
    ];

    protected $casts = [
        'is_active'       => 'bool',
        'is_mixed_group'  => 'bool',
        'is_subsidized'   => 'bool',
    ];

    public function statuses(): HasMany
    {
        return $this->hasMany(ParliamentaryGroupStatus::class);
    }

    public function statusDetails(): HasMany
    {
        return $this->hasMany(ParliamentaryGroupStatusDetail::class);
    }
}
