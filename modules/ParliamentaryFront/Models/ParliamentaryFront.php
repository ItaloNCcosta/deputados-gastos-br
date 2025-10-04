<?php 

declare(strict_types=1);

namespace Modules\ParliamentaryFront\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\FederalDeputy\Models\FederalDeputy;
use Modules\Legislature\Models\Legislature;
use Modules\ParliamentaryFrontCoordinator\Models\ParliamentaryFrontCoordinator;
use OwenIt\Auditing\Contracts\Auditable;

final class ParliamentaryFront extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use HasUuids;

    public bool $incrementing = false;
    protected string $keyType = 'string';

    protected $fillable = [
        'external_id',
        'source_api',
        'email',
        'legislature_id',
        'status_id',
        'keywords',
        'status',
        'phone',
        'title',
        'resource_uri',
        'document_url',
        'website_url',
    ];

    public function legislature(): BelongsTo
    {
        return $this->belongsTo(Legislature::class);
    }

    public function coordinators(): HasMany
    {
        return $this->hasMany(ParliamentaryFrontCoordinator::class, 'caucus_id');
    }

    public function federalDeputies(): BelongsToMany
    {
        return $this->belongsToMany(
            FederalDeputy::class,
            'parliamentary_front_members',
            'caucus_id',
            'deputy_id'
        );
    }
}