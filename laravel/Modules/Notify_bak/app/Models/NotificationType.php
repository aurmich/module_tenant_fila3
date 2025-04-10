<?php

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationType query()
 * @mixin \Eloquent
 */
=======
>>>>>>> origin/dev
class NotificationType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'template',
    ];
}
