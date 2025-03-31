<?php

declare(strict_types=1);

namespace Modules\Reporting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Xot\Traits\Updater;

/**
 * Base model for all models in the Reporting module.
 * This class provides common functionality for all models in this module.
 */
abstract class BaseModel extends Model
{
    use HasFactory;
    use Updater;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the table name for the model with proper tenant prefix if applicable.
     */
    public function getTable(): string
    {
        return config('tenant.db_prefix') . parent::getTable();
    }
}
