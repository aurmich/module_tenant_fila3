<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * Class BaseActivity.
 *
 * Base class for all activity models in the Activity module.
 * Extends Spatie's Activity model to provide common functionality.
 */
abstract class BaseActivity extends SpatieActivity {}
