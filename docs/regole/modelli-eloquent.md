# Regole per Modelli Eloquent in SaluteOra

## Estensione delle Classi Base

Tutti i modelli Eloquent nei moduli del progetto SaluteOra **DEVONO** estendere `Modules\Xot\Models\XotBaseModel` e non direttamente `Illuminate\Database\Eloquent\Model`.

### ❌ NON utilizzare:

```php
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // ...
}
```

### ✅ Utilizzare invece:

```php
use Modules\Xot\Models\XotBaseModel;

class Patient extends XotBaseModel
{
    // ...
}
```

## Metodo casts() vs Proprietà $casts

La proprietà `$casts` è **deprecata** nel progetto SaluteOra. Utilizzare sempre il metodo `casts()` per definire i cast degli attributi.

### ❌ NON utilizzare:

```php
protected $casts = [
    'birth_date' => 'date',
    'is_active' => 'boolean',
];
```

### ✅ Utilizzare invece:

```php
public function casts(): array
{
    return array_merge(parent::casts(), [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ]);
}
```

## Trait Comuni

### Tenant Multi-Tenant

Tutti i modelli che appartengono a un tenant devono utilizzare il trait `BelongsToTenant`:

```php
use Modules\Tenant\Traits\BelongsToTenant;

class Patient extends XotBaseModel
{
    use BelongsToTenant;
    // ...
}
```

### SoftDeletes

Utilizzare `SoftDeletes` per i modelli che non devono essere eliminati definitivamente:

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends XotBaseModel
{
    use SoftDeletes;
    // ...
}
```

### HasFactory per Testing

Utilizzare `HasFactory` per supportare la creazione di modelli nei test:

```php
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends XotBaseModel
{
    use HasFactory;
    // ...
}
```

## Visibilità dei Metodi e Proprietà

- Utilizzare `protected` per le proprietà interne del modello
- Utilizzare `public` per i metodi accessibili dall'esterno
- Non dichiarare proprietà con visibilità `public` se non necessario

## Tipizzazione Stretta

- Utilizzare **sempre** `declare(strict_types=1);` all'inizio di ogni file
- Aggiungere type hints per tutti i parametri dei metodi
- Specificare il tipo di ritorno per tutti i metodi
- Utilizzare tipi PHP nativi (string, int, bool, array, etc.)

## Relazioni

- Utilizzare i metodi con type hint per le relazioni
- Specificare il tipo di ritorno della relazione

```php
public function patient(): BelongsTo
{
    return $this->belongsTo(Patient::class);
}

public function documents(): HasMany
{
    return $this->hasMany(Document::class);
}
```

## Accessors e Mutators

Utilizzare i metodi get*Attribute e set*Attribute con tipi di ritorno espliciti:

```php
public function getFullNameAttribute(): string
{
    return "{$this->name} {$this->surname}";
}

public function setEmailAttribute(string $value): void
{
    $this->attributes['email'] = strtolower($value);
}
```

## Collegamenti Tra Moduli

Per fare riferimento a modelli in altri moduli, utilizzare il namespace completo:

```php
public function appointments(): HasMany
{
    return $this->hasMany(\Modules\Dental\Models\Appointment::class);
}
```

Ultima modifica: 01/04/2025
