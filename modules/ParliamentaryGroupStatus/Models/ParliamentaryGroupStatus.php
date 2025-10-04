<?php

declare(strict_types=1);

namespace Modules\ParliamentaryGroupStatus\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ParliamentaryGroup\Models\ParliamentaryGroup;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryGroupStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'parliamentary_group_id',
        'status_date',
        'legislature_code',
        'official_letter_title',
        'official_letter_uri',
        'president_name',
        'president_uri',
        'is_current',
    ];

    protected $casts = [
        'status_date' => 'date',
        'is_current'  => 'bool',
    ];

    public function parliamentaryGroup(): BelongsTo
    {
        return $this->belongsTo(ParliamentaryGroup::class);
    }
}
