<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Job\Models;

<<<<<<< HEAD
<<<<<<< HEAD
=======
use Modules\Job\Database\Factories\FailedJobFactory;
>>>>>>> 090be5b (first)
=======
use Modules\Job\Database\Factories\FailedJobFactory;
>>>>>>> dev
use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Job\Models\FailedJob
 *
 * @method static \Modules\Job\Database\Factories\FailedJobFactory factory($count = null, $state = [])
 * @method static Builder|FailedJob newModelQuery()
 * @method static Builder|FailedJob newQuery()
 * @method static Builder|FailedJob query()
<<<<<<< HEAD
<<<<<<< HEAD
 *
=======
>>>>>>> 090be5b (first)
=======
>>>>>>> dev
 * @property int $id
 * @property string $uuid
 * @property string $connection
 * @property string $queue
 * @property array $payload
 * @property string $exception
 * @property string $failed_at
<<<<<<< HEAD
<<<<<<< HEAD
 *
=======
>>>>>>> 090be5b (first)
=======
>>>>>>> dev
 * @method static Builder|FailedJob whereConnection($value)
 * @method static Builder|FailedJob whereException($value)
 * @method static Builder|FailedJob whereFailedAt($value)
 * @method static Builder|FailedJob whereId($value)
 * @method static Builder|FailedJob wherePayload($value)
 * @method static Builder|FailedJob whereQueue($value)
 * @method static Builder|FailedJob whereUuid($value)
<<<<<<< HEAD
<<<<<<< HEAD
 *
=======
>>>>>>> 090be5b (first)
=======
>>>>>>> dev
 * @mixin \Eloquent
 */
class FailedJob extends BaseModel
{
    protected $fillable = [
        'id',
        'uuid',
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
