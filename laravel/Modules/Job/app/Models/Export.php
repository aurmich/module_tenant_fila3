<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Job\Models;

use Eloquent;
use Filament\Actions\Exports\Models\Export as BaseExport;

/**
 * 
 *
 * @method static \Modules\Job\Database\Factories\ExportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Export newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Export newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Export query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string $file_disk
 * @property string|null $file_name
 * @property string $exporter
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereExporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereFileDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereProcessedRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereSuccessfulRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereTotalRows($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUserId($value)
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @property \Illuminate\Database\Eloquent\Model|Eloquent|null $user
 * @property string|null $user_type
 * @method static \Illuminate\Database\Eloquent\Builder|Export whereUserType($value)
 * @mixin \Eloquent
 * @mixin Eloquent
 */
class Export extends BaseExport
{
    /** @var string */
    protected $connection = 'job';

    protected $fillable = [
        'id',
        'completed_at',
        'file_disk',
        'file_name',
        'exporter',
        'processed_rows',
        'total_rows',
        'successful_rows',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'data' => 'json',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',

            'payload' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'completed_at' => 'datetime',
            // 'updated_at' => 'datetime:Y-m-d H:00',
            // 'created_at' => 'datetime:Y-m-d',
            // 'created_at' => 'datetime:d/m/Y H:i'
        ];
    }
}
