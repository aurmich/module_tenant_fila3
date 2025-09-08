<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Sushi\Sushi;

/**
 * @property int|null $id
 * @property string|null $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 *
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 *
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 * @method static Domain|null first()
 * @method static \Illuminate\Database\Eloquent\Collection<int, Domain> get()
 * @method static Domain create(array $attributes = [])
 * @method static Domain firstOrCreate(array $attributes = [], array $values = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain where(string|\Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereNotNull(string|\Illuminate\Contracts\Database\Query\Expression $columns)
 * @method static int count(string $columns = '*')
 *
 * @mixin IdeHelperDomain
 * @mixin \Eloquent
 */
class Domain extends BaseModel
{
    use Sushi;

    /**
     * Model Rows.
     *
     * @return array
     */
    public function getRows()
    {
        $products = app(GetDomainsArrayAction::class)->execute();

        return $products;
    }
}
