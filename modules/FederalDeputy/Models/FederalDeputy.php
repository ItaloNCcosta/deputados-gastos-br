<?php

declare(strict_types=1);

namespace Modules\FederalDeputy\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\DeputyOffice\Models\DeputyOffice;
use Modules\DeputySocialLink\Models\DeputySocialLink;
use Modules\DeputyStatus\Models\DeputyStatus;
use Modules\ParliamentaryBody\Models\ParliamentaryBody;
use Modules\ParliamentaryFront\Models\ParliamentaryFront;
use Modules\PoliticalPartyMembership\Models\PoliticalPartyMembership;
use OwenIt\Auditing\Contracts\Auditable;

final class FederalDeputy extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'cpf',
        'death_date',
        'birth_date',
        'education_level',
        'birth_city',
        'legal_name',
        'sex',
        'birth_state_code',
        'resource_uri',
        'website_url',
    ];

    protected $casts = [
        'death_date' => 'date',
        'birth_date' => 'date',
    ];

    public function statuses(): HasMany
    {
        return $this->hasMany(DeputyStatus::class, 'deputy_id');
    }

    public function offices(): HasManyThrough
    {
        return $this->hasManyThrough(
            DeputyOffice::class,
            DeputyStatus::class,
            'deputy_id',
            'deputy_status_id'
        );
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(DeputySocialLink::class, 'deputy_id');
    }

    public function parliamentaryBodies(): BelongsToMany
    {
        return $this->belongsToMany(
            ParliamentaryBody::class,
            'deputy_parliamentary_bodies',
            'deputy_id',
            'body_id'
        );
    }

    public function parliamentaryFronts(): BelongsToMany
    {
        return $this->belongsToMany(
            ParliamentaryFront::class,
            'parliamentary_front_members',
            'deputy_id',
            'caucus_id'
        );
    }

    public function politicalPartyMemberships(): HasMany
    {
        return $this->hasMany(PoliticalPartyMembership::class, 'deputy_id');
    }
}
