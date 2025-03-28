<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Modules\Gdpr\Models\Consent.
 *
 * @property string         $id
 * @property string         $treatment_id
 * @property string         $subject_id
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property Treatment|null $treatment
 *
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 * @method static Builder|Consent                                 newModelQuery()
 * @method static Builder|Consent                                 newQuery()
 * @method static Builder|Consent                                 query()
 * @method static Builder|Consent                                 whereCreatedAt($value)
 * @method static Builder|Consent                                 whereId($value)
 * @method static Builder|Consent                                 whereSubjectId($value)
 * @method static Builder|Consent                                 whereTreatmentId($value)
 * @method static Builder|Consent                                 whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Consent extends BaseModel
{
    use HasUuids;

    // protected $table = 'consent';

    public $incrementing = false;

    public $fillable = ['subject_id', 'treatment_id'];

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
