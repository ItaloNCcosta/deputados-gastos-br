<?php

declare(strict_types=1);

namespace Modules\DeputyStatus\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\DeputyOffice\Models\DeputyOffice;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\Legislature\Models\Legislature;
use OwenIt\Auditing\Contracts\Auditable;

final class DeputyStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'deputy_id',
        'electoral_condition',
        'date',
        'status_description',
        'email',
        'legislature_id',
        'name',
        'ballot_name',
        'party_acronym',
        'state_code',
        'status',
        'resource_uri',
        'party_uri',
        'photo_url',
        'is_current',
    ];

    protected $casts = [
        'date' => 'date',
        'is_current' => 'bool',
    ];

    public function federalDeputy(): BelongsTo
    {
        return $this->belongsTo(FederalDeputy::class, 'deputy_id');
    }

    public function legislature(): BelongsTo
    {
        return $this->belongsTo(Legislature::class);
    }

    public function offices(): HasMany
    {
        return $this->hasMany(DeputyOffice::class, 'deputy_status_id');
    }
}
