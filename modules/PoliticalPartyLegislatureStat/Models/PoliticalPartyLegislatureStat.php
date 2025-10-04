<?php

declare(strict_types=1);

namespace Modules\PoliticalPartyLegislatureStat\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\PoliticalParty\Models\PoliticalParty;
use Modules\PoliticalPartyLeader\Models\PoliticalPartyLeader;
use OwenIt\Auditing\Contracts\Auditable;

final class PoliticalPartyLegislatureStat extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'party_id',
        'date',
        'legislature_code',
        'status',
        'members_total',
        'sworn_in_total',
        'members_resource_uri',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function politicalParty(): BelongsTo
    {
        return $this->belongsTo(PoliticalParty::class, 'party_id');
    }

    public function leaders(): HasMany
    {
        return $this->hasMany(PoliticalPartyLeader::class, 'party_legislature_stats_id');
    }
}
