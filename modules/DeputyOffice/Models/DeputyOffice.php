<?php

declare(strict_types=1);

namespace Modules\DeputyOffice\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\DeputyStatus\Models\DeputyStatus;
use OwenIt\Auditing\Contracts\Auditable;

final class DeputyOffice extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'deputy_status_id',
        'floor',
        'email',
        'name',
        'building',
        'room',
        'phone',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(DeputyStatus::class, 'deputy_status_id');
    }
}
