<?php

declare(strict_types=1);

namespace Modules\LegislativeEventBody\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\LegislativeEvent\Models\LegislativeEvent;
use Modules\ParliamentaryBody\Models\ParliamentaryBody;
use OwenIt\Auditing\Contracts\Auditable;

final class LegislativeEventBody extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'event_id',
        'body_id',
    ];

    public function legislativeEvent(): BelongsTo
    {
        return $this->belongsTo(LegislativeEvent::class, 'event_id');
    }

    public function parliamentaryBody(): BelongsTo
    {
        return $this->belongsTo(ParliamentaryBody::class, 'body_id');
    }
}
