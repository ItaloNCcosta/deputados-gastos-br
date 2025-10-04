<?php

declare(strict_types=1);

namespace Modules\ParliamentaryGroupStatusDetail\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ParliamentaryGroup\Models\ParliamentaryGroup;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryGroupStatusDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'parliamentary_group_id',
        'status_date',
        'document',
        'legislature_code',
        'official_letter_author_name',
        'official_letter_author_type',
        'official_letter_author_uri',
        'official_letter_presented_at',
        'official_letter_published_at',
        'official_letter_title',
        'official_letter_uri',
        'president_name',
        'president_uri',
    ];

    protected $casts = [
        'status_date' => 'date',
        'official_letter_presented_at' => 'date',
        'official_letter_published_at' => 'date',
    ];

    public function parliamentaryGroup(): BelongsTo
    {
        return $this->belongsTo(ParliamentaryGroup::class);
    }
}
