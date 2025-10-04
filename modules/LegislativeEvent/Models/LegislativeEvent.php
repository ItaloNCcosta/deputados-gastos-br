<?php

declare(strict_types=1);

namespace Modules\LegislativeEvent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\LegislativeEventChamberLocation\Models\LegislativeEventChamberLocation;
use Modules\LegislativeEventRequest\Models\LegislativeEventRequest;
use Modules\ParliamentaryBody\Models\ParliamentaryBody;
use OwenIt\Auditing\Contracts\Auditable;

final class LegislativeEvent extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'start_at',
        'end_at',
        'description',
        'event_type_description',
        'phases',
        'external_location',
        'status',
        'resource_uri',
        'guests_uri',
        'representatives_uri',
        'agenda_document_url',
        'record_url',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    public function chamberLocation(): HasOne
    {
        return $this->hasOne(LegislativeEventChamberLocation::class, 'event_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(LegislativeEventRequest::class, 'event_id');
    }

    public function parliamentaryBodies(): BelongsToMany
    {
        return $this->belongsToMany(
            ParliamentaryBody::class,
            'legislative_event_bodies',
            'event_id',
            'body_id'
        );
    }
}
