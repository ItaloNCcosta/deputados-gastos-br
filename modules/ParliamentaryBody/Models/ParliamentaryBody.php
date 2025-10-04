<?php

declare(strict_types=1);

namespace Modules\ParliamentaryBody\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\LegislativeEvent\Models\LegislativeEvent;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryBody extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'alias',
        'house',
        'body_type_code',
        'end_date',
        'original_end_date',
        'start_date',
        'installation_date',
        'name',
        'published_name',
        'short_name',
        'room',
        'acronym',
        'body_type',
        'resource_uri',
        'website_url',
    ];

    protected $casts = [
        'end_date'          => 'date',
        'original_end_date' => 'date',
        'start_date'        => 'date',
        'installation_date' => 'date',
    ];

    public function legislativeEvents(): BelongsToMany
    {
        return $this->belongsToMany(
            LegislativeEvent::class,
            'legislative_event_bodies',
            'body_id',
            'event_id'
        );
    }

    public function federalDeputies(): BelongsToMany
    {
        return $this->belongsToMany(
            FederalDeputy::class,
            'deputy_parliamentary_bodies',
            'body_id',
            'deputy_id'
        );
    }
}
