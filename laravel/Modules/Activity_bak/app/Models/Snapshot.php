<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

/**
 * Modules\Activity\Models\Snapshot.
 *
 * @property int $id
 * @property string $aggregate_uuid
 * @property int $aggregate_version
 * @property array $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot uuid(string $uuid)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereAggregateUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereAggregateVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Snapshot whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Snapshot extends BaseSnapshot
{
    /** @var list<string> */
    protected $fillable = ['id', 'aggregate_uuid', 'aggregate_version', 'state', 'created_at', 'updated_at'];

    /** @var string */
    protected $connection = 'activity';
}
