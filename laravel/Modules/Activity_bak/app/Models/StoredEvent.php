<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

/**
 * Class StoredEvent.
 * 
 * Represents a stored event in the activity module.
 *
 * @property int $id
 * @property string|null $aggregate_uuid
 * @property int|null $aggregate_version
 * @property int $event_version
 * @property string $event_class
 * @property array<array-key, mixed> $event_properties
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $meta_data
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read \Spatie\EventSourcing\StoredEvents\ShouldBeStored|null $event
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent afterVersion(int $version)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<EloquentStoredEvent> all()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<EloquentStoredEvent> get()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent lastEvent(string ...$eventClasses)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent newModelQuery()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent newQuery()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent query()
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent startingFrom(int $storedEventId)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateRoot(string $uuid)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateUuid($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateVersion($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedAt($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedBy($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEvent(string ...$eventClasses)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventClass($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventProperties($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventVersion($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereId($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereMetaData($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIs(string $property, ?mixed $value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIsNot(string $property, ?mixed $value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent whereUpdatedBy($value)
 * @method static \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder<static>|StoredEvent withMetaDataAttributes()
 * @mixin \Eloquent
 */
class StoredEvent extends EloquentStoredEvent
{
    protected $table = 'stored_events';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'aggregate_uuid',
        'aggregate_version',
        'event_version',
        'event_class',
        'event_properties',
        'meta_data',
        'created_at',
        'updated_by',
        'created_by',
    ];

    /** @var string */
    protected $connection = 'activity';
}
