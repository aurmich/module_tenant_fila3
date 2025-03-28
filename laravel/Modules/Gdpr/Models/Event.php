<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

use function Safe\json_encode;

/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string                          $id
 * @property string|null                     $treatment_id
 * @property string|null                     $consent_id
 * @property string                          $subject_id
 * @property string                          $ip
 * @property string                          $action
 * @property string                          $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Consent|null                    $consent
 *
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder|Event                                 newModelQuery()
 * @method static Builder|Event                                 newQuery()
 * @method static Builder|Event                                 query()
 * @method static Builder|Event                                 whereAction($value)
 * @method static Builder|Event                                 whereConsentId($value)
 * @method static Builder|Event                                 whereCreatedAt($value)
 * @method static Builder|Event                                 whereId($value)
 * @method static Builder|Event                                 whereIp($value)
 * @method static Builder|Event                                 wherePayload($value)
 * @method static Builder|Event                                 whereSubjectId($value)
 * @method static Builder|Event                                 whereTreatmentId($value)
 * @method static Builder|Event                                 whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    use HasUuids;

    // protected $table = 'event';

    public $fillable = [
        'id',
        'action',
        'treatment_id',
        'consent_id',
        'subject_id',
        'payload',
    ];

    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class);
    }

    public function setPayloadAttribute(?string $value): void
    {
        $this->attributes['payload'] = Crypt::encrypt(json_encode($value, JSON_THROW_ON_ERROR));
    }

    public function setIpAttribute(?string $value): void
    {
        $this->attributes['ip'] = Crypt::encrypt($value);
    }
}
