<?php

declare(strict_types=1);

namespace Modules\ParliamentaryFrontCoordinator\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\Legislature\Models\Legislature;
use Modules\ParliamentaryFront\Models\ParliamentaryFront;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryFrontCoordinator extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'caucus_id',
        'deputy_id',
        'email',
        'legislature_id',
        'name',
        'party_acronym',
        'state_code',
        'resource_uri',
        'party_uri',
        'photo_url',
    ];

    public function parliamentaryFront(): BelongsTo
    {
        return $this->belongsTo(ParliamentaryFront::class, 'caucus_id');
    }

    public function federalDeputy(): BelongsTo
    {
        return $this->belongsTo(FederalDeputy::class, 'deputy_id');
    }

    public function legislature(): BelongsTo
    {
        return $this->belongsTo(Legislature::class);
    }
}
