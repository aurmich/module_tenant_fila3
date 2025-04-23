<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Sushi\Sushi;

/**
<<<<<<< HEAD
<<<<<<< HEAD
 * Modello per la gestione dei domini tenant.
 *
 * @property int|null $id
 * @property string|null $name
 *
=======
=======
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)
>>>>>>> ad1566e (fix: auto resolve conflict)
 * 
 *
 * @property int|null $id
 * @property string|null $name
<<<<<<< HEAD
>>>>>>> 9ca9877 (Merge remote-tracking branch 'origin/dev' into dev)
=======
<<<<<<< HEAD
=======
=======
 * @property int|null $id
 * @property string|null $name
 *
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
>>>>>>> ad1566e (fix: auto resolve conflict)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
<<<<<<< HEAD
<<<<<<< HEAD
 *
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Modules\Broker\Models\Profile|null $updater
 *
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 *
=======
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Modules\Broker\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
>>>>>>> 9ca9877 (Merge remote-tracking branch 'origin/dev' into dev)
=======
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Modules\Broker\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
=======
<<<<<<< HEAD
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Modules\Broker\Models\Profile|null $updater
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
=======
 *
 * @property-read \Modules\Broker\Models\Profile|null $creator
 * @property-read \Modules\Broker\Models\Profile|null $updater
 *
 * @method static \Modules\Tenant\Database\Factories\DomainFactory factory($count = null, $state = [])
 *
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
>>>>>>> ad1566e (fix: auto resolve conflict)
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
