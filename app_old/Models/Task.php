<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Modules\Job\Models\Traits\FrontendSortable;
use Webmozart\Assert\Assert;

/**
 * Modules\Job\Models\Task.
 *
 * @property string $id
 * @property string $description
 * @property string $command
 * @property string|null $parameters
 * @property string|null $expression
 * @property string $timezone
 * @property int $is_active
 * @property int $dont_overlap
 * @property int $run_in_maintenance
 * @property string|null $notification_email_address
 * @property string|null $notification_phone_number
 * @property string $notification_slack_webhook
 * @property int $auto_cleanup_num
 * @property string|null $auto_cleanup_type
 * @property int $run_on_one_server
 * @property int $run_in_background
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property int $order_column
 * @property string $status
 * @property string $priority_id
 *                               property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\Frequency> $frequencies
 * @property int|null $frequencies_count
 * @property bool $activated
 * @property float $average_runtime
 * @property Result|null $last_result
 * @property string $upcoming
 * @property \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property int|null $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Job\Models\Result> $results
 * @property int|null $results_count
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task sortableBy(array $sortableColumns, array $defaultSort = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereAutoCleanupNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereAutoCleanupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDontOverlap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereExpression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereNotificationSlackWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunInBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunInMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereRunOnOneServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedBy($value)
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @mixin \Eloquent
 */
class Task extends BaseModel
{
    // use HasFrequencies;
    use FrontendSortable;
    use HasFactory;
    use Notifiable;

    /** @var list<string> */
    protected $fillable = [
        'id',
        'description',
        'command',
        'parameters',
        'expression',
        'timezone',
        'is_active',
        'dont_overlap',
        'run_in_maintenance',
        'notification_email_address',
        'notification_phone_number',
        'notification_slack_webhook',
        'auto_cleanup_type',
        'auto_cleanup_num',
        'run_on_one_server',
        'run_in_background',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    /** @var list<string> */
    protected $appends = [
        'activated',
        'upcoming',
        'last_result',
        'average_runtime',
    ];

    /**
     * Activated Accessor.
     */
    public function getActivatedAttribute(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Upcoming Accessor.
     *
     * throws \Exception
     */
    public function getUpcomingAttribute(): string
    {
        // return CronExpression::factory($this->getCronExpression())->getNextRunDate()->format('Y-m-d H:i:s');
        return 'preso';
    }

    /**
     * Frequencies Relation.
     */
    public function frequencies(): HasMany
    {
        return $this->hasMany(Frequency::class, 'task_id', 'id')->with('parameters');
    }

    /**
     * Results Relation.
     */
    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'task_id', 'id');
    }

    /**
     * Returns the most recent result entry for this task.
     */
    public function getLastResultAttribute(): ?Result
    {
        $res = $this->results()->orderBy('id', 'desc')->first();
        if ($res == null) {
            return null;
        }
        Assert::isInstanceOf($res, Result::class);

        return $res;
    }

    public function getAverageRuntimeAttribute(): float
    {
        /**
         * @var float $avg_duration
         */
        $avg_duration = $this->results()->avg('duration');

        return (float) $avg_duration;
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail(): ?string
    {
        return $this->notification_email_address;
    }

    /**
     * Route notifications for the Nexmo channel.
     */
    public function routeNotificationForNexmo(): ?string
    {
        return $this->notification_phone_number;
    }

    /**
     * Route notifications for the Slack channel.
     */
    public function routeNotificationForSlack(): ?string
    {
        return $this->notification_slack_webhook;
    }

    /**
     * Attempt to perform clean on task results.
     */
    public function autoCleanup(): void
    {
        if ($this->auto_cleanup_num > 0) {
            if ($this->auto_cleanup_type === 'results') {
                $oldest_id = $this->results()
                    ->orderBy('ran_at', 'desc')
                    ->limit($this->auto_cleanup_num)
                    ->get()
                    ->min('id');
                do {
                    $rowsToDelete = $this->results()
                        ->where('id', '<', $oldest_id)
                        ->limit(50)
                        ->getQuery()
                        ->select('id')
                        ->pluck('id');

                    Result::query()
                        ->whereIn('id', $rowsToDelete)
                        ->delete();
                } while ($rowsToDelete->count() > 0);
            } else {
                do {
                    $rowsToDelete = $this->results()
                        ->where('ran_at', '<', Carbon::now()->subDays($this->auto_cleanup_num - 1))
                        ->limit(50)
                        ->getQuery()
                        ->select('id')
                        ->pluck('id');

                    Result::query()
                        ->whereIn('id', $rowsToDelete)
                        ->delete();
                } while ($rowsToDelete->count() > 0);
            }
        }
    }
}
