<?php 

declare(strict_types=1);

namespace Modules\PoliticalParty\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\PoliticalPartyLeader\Models\PoliticalPartyLeader;
use Modules\PoliticalPartyLegislatureStat\Models\PoliticalPartyLegislatureStat;
use Modules\PoliticalPartyMembership\Models\PoliticalPartyMembership;
use OwenIt\Auditing\Contracts\Auditable;

final class PoliticalParty extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'name',
        'electoral_number',
        'acronym',
        'resource_uri',
        'facebook_url',
        'logo_url',
        'website_url',
    ];

    public function legislatureStats(): HasMany
    {
        return $this->hasMany(PoliticalPartyLegislatureStat::class, 'party_id');
    }

    public function leaders(): HasManyThrough
    {
        return $this->hasManyThrough(
            PoliticalPartyLeader::class,
            PoliticalPartyLegislatureStat::class,
            'party_id',
            'party_legislature_stats_id'
        );
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(PoliticalPartyMembership::class, 'party_id');
    }
}