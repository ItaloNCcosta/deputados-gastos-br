<?php

declare(strict_types=1);

namespace Modules\PoliticalPartyLeader\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Legislature\Models\Legislature;
use Modules\PoliticalPartyLegislatureStat\Models\PoliticalPartyLegislatureStat;
use OwenIt\Auditing\Contracts\Auditable;

final class PoliticalPartyLeader extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'party_legislature_stats_id',
        'legislature_id',
        'name',
        'party_acronym',
        'state_code',
        'resource_uri',
        'party_uri',
        'photo_url',
    ];

    public function legislatureStat(): BelongsTo
    {
        return $this->belongsTo(PoliticalPartyLegislatureStat::class, 'party_legislature_stats_id');
    }

    public function legislature(): BelongsTo
    {
        return $this->belongsTo(Legislature::class);
    }
}
