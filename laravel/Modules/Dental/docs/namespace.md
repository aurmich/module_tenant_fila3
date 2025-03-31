# Namespace del Modulo Dental

## Struttura Base
Il namespace base del modulo Dental è:
```php
Modules\Dental
```

## Organizzazione dei Namespace

### Models
```php
Modules\Dental\Models
```

### Controllers
```php
Modules\Dental\Http\Controllers
```

### Services
```php
Modules\Dental\Services
```

### Jobs
```php
Modules\Dental\Jobs
```

### Events
```php
Modules\Dental\Events
```

### Listeners
```php
Modules\Dental\Listeners
```

### Notifications
```php
Modules\Dental\Notifications
```

### Providers
```php
Modules\Dental\Providers
```

### Console
```php
Modules\Dental\Console
```

### Filament
```php
Modules\Dental\Filament
```

## Best Practices
1. Utilizzare sempre il namespace completo
2. Non utilizzare il namespace `App` come suffisso
3. Mantenere la coerenza con gli altri moduli
4. Seguire la struttura PSR-4 per l'autoloading

## Esempio di Utilizzo
```php
<?php

namespace Modules\Dental\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    // ...
}
```

## Note Importanti
- Il namespace base `Modules\Dental` è il punto di ingresso del modulo
- Tutte le classi del modulo devono essere sotto questo namespace
- Non utilizzare il namespace `App` come era stato erroneamente suggerito prima
- La struttura del namespace riflette la struttura delle directory del modulo 