# Namespace del Modulo Reporting

## Struttura Base
Il namespace base del modulo Reporting è:
```php
Modules\Reporting
```

## Organizzazione dei Namespace

### Models
```php
Modules\Reporting\Models
```

### Controllers
```php
Modules\Reporting\Http\Controllers
```

### Services
```php
Modules\Reporting\Services
```

### Jobs
```php
Modules\Reporting\Jobs
```

### Events
```php
Modules\Reporting\Events
```

### Listeners
```php
Modules\Reporting\Listeners
```

### Notifications
```php
Modules\Reporting\Notifications
```

### Providers
```php
Modules\Reporting\Providers
```

### Console
```php
Modules\Reporting\Console
```

### Filament
```php
Modules\Reporting\Filament
```

## Best Practices
1. Utilizzare sempre il namespace completo
2. Non utilizzare il namespace `App` come suffisso
3. Mantenere la coerenza con gli altri moduli
4. Seguire la struttura PSR-4 per l'autoloading

## Esempio di Utilizzo
```php
<?php

namespace Modules\Reporting\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // ...
}
```

## Note Importanti
- Il namespace base `Modules\Reporting` è il punto di ingresso del modulo
- Tutte le classi del modulo devono essere sotto questo namespace
- Non utilizzare il namespace `App` come era stato erroneamente suggerito prima
- La struttura del namespace riflette la struttura delle directory del modulo 