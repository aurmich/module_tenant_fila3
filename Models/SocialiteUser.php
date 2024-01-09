<?php

declare(strict_types=1);

/**
 * inspired by  DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Datas\XotData;

class SocialiteUser extends BaseModel
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        // 'id',
        'user_id',
        'provider',
        'provider_id',
        'token',
        'name',
        'email',
        'avatar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            XotData::resolveUserClass()
        );
    }
}
