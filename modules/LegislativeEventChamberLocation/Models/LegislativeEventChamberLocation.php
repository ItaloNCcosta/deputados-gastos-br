<?php

declare(strict_types=1);

namespace Modules\LegislativeEventChamberLocation\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\LegislativeEvent\Models\LegislativeEvent;
use OwenIt\Auditing\Contracts\Auditable;

final class LegislativeEventChamberLocation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'event_id',
        'floor',
        'name',
        'building',
        'room',
    ];

    public function legislativeEvent(): BelongsTo
    {
        return $this->belongsTo(LegislativeEvent::class, 'event_id');
    }
}
