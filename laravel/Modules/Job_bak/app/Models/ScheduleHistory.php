<?php

declare(strict_types=1);

/**
 * @see HusamTariq\FilamentDatabaseSchedule
 */

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modules\Job\Models\ScheduleHistory.
 *
 * @property Schedule|null $command
 * @method static \Modules\Job\Database\Factories\ScheduleHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory query()
 * @property int $id
 * @property array|null $params
 * @property string $output
 * @property array|null $options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $schedule_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScheduleHistory whereUpdatedBy($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @mixin \Eloquent
 */
class ScheduleHistory extends BaseModel
{
    /*
     * The database table used by the model.
     *
     * @var string
     */
    // protected $table;

    protected $fillable = [
        'command',
        'params',
        'output',
        'options',
    ];
    /*
         * Creates a new instance of the model.
         *
         * @param array $attributes
         * @return void
         */
    /*
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = Config::get('filament-database-schedule.table.schedule_histories', 'schedule_histories');
    }

    */

    public function command(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',

            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',

            'params' => 'array',
            'options' => 'array',
        ];
    }
}
