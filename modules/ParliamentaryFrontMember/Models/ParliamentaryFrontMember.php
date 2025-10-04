<?php

declare(strict_types=1);

namespace Modules\ParliamentaryFrontMember\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\ParliamentaryFront\Models\ParliamentaryFront;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryFrontMember extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'caucus_id',
        'deputy_id',
    ];

    public function parliamentaryFront(): BelongsTo
    {
        return $this->belongsTo(ParliamentaryFront::class, 'caucus_id');
    }

    public function federalDeputy(): BelongsTo
    {
        return $this->belongsTo(FederalDeputy::class, 'deputy_id');
    }
}
