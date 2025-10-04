<?php

declare(strict_types=1);

namespace Modules\PoliticalPartyMembership\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\Legislature\Models\Legislature;
use Modules\PoliticalParty\Models\PoliticalParty;
use OwenIt\Auditing\Contracts\Auditable;

final class PoliticalPartyMembership extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'party_id',
        'deputy_id',
        'legislature_id',
        'affiliation_date',
        'disaffiliation_date',
    ];

    protected $casts = [
        'affiliation_date'   => 'date',
        'disaffiliation_date' => 'date',
    ];

    public function politicalParty(): BelongsTo
    {
        return $this->belongsTo(PoliticalParty::class, 'party_id');
    }

    public function federalDeputy(): BelongsTo
    {
        return $this->belongsTo(FederalDeputy::class, 'deputy_id');
    }

    public function legislature(): BelongsTo
    {
        return $this->belongsTo(Legislature::class);
    }
}
