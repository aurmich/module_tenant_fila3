<?php

/**
 * @see https://github.com/mooxphp/jobs/tree/main
 */

declare(strict_types=1);

namespace Modules\Job\Models;

/**
 * Modules\Job\Models\JobsWaiting.
 *
 * @property int $id
 * @property string $queue
 * @property array $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $display_name
 * @method static \Modules\Job\Database\Factories\JobsWaitingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereAvailableAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereQueue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobsWaiting whereUpdatedBy($value)
 * @property mixed $status
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
class JobsWaiting extends Job {}
