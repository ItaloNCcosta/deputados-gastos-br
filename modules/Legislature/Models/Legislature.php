<?php

declare(strict_types=1);

namespace Modules\Legislature\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\DeputyStatus\Models\DeputyStatus;
use Modules\ParliamentaryFront\Models\ParliamentaryFront;
use Modules\ParliamentaryFrontCoordinator\Models\ParliamentaryFrontCoordinator;
use Modules\PoliticalPartyLeader\Models\PoliticalPartyLeader;
use Modules\PoliticalPartyMembership\Models\PoliticalPartyMembership;
use OwenIt\Auditing\Contracts\Auditable;

final class Legislature extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasUuids, HasFactory;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'start_date',
        'end_date',
        'resource_uri',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function parliamentaryFronts(): HasMany
    {
        return $this->hasMany(ParliamentaryFront::class);
    }

    public function parliamentaryFrontCoordinators(): HasMany
    {
        return $this->hasMany(ParliamentaryFrontCoordinator::class);
    }

    public function politicalPartyLeaders(): HasMany
    {
        return $this->hasMany(PoliticalPartyLeader::class);
    }

    public function deputyStatuses(): HasMany
    {
        return $this->hasMany(DeputyStatus::class);
    }

    public function politicalPartyMemberships(): HasMany
    {
        return $this->hasMany(PoliticalPartyMembership::class);
    }
}
