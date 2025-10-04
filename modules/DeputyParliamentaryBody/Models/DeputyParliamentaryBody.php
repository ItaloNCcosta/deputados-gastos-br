<?php

declare(strict_types=1);

namespace Modules\DeputyParliamentaryBody\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

final class DeputyParliamentaryBody extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'deputy_id',
        'body_id',
        'start_date',
        'end_date',
        'role_title',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}
