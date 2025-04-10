<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieSnapshot;

/**
 * Class BaseSnapshot.
 *
 * Base class for snapshots extending Spatie's EloquentSnapshot.
 */
abstract class BaseSnapshot extends SpatieSnapshot
{
    /** @var string */
    protected $connection = 'activity';
}
