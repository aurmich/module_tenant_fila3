<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent as SpatieStoredEvent;

/**
 * Class BaseStoredEvent.
 *
 * Base class for stored events extending Spatie's EloquentStoredEvent.
 */
abstract class BaseStoredEvent extends SpatieStoredEvent
{
    /** @var string */
    protected $connection = 'activity';
}
