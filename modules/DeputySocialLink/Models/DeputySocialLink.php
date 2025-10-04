<?php

declare(strict_types=1);

namespace Modules\DeputySocialLink\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FederalDeputy\Models\FederalDeputy;
use OwenIt\Auditing\Contracts\Auditable;

final class DeputySocialLink extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'deputy_id',
        'url',
    ];

    public function federalDeputy(): BelongsTo
    {
        return $this->belongsTo(FederalDeputy::class, 'deputy_id');
    }
}
