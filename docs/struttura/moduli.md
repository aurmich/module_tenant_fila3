# Struttura Moduli e Dipendenze

## Overview
La struttura dei moduli segue lo standard di Laravel Modules, che è compatibile con Laraxot. Ogni modulo è un'unità indipendente con le proprie risorse, ma può dipendere da altri moduli per funzionalità specifiche.

## Struttura Base di un Modulo

```
Modules/
└── [ModuleName]/
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   ├── Middleware/
    │   │   └── Requests/
    │   ├── Models/
    │   ├── Providers/
    │   └── Services/
    ├── config/
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    ├── resources/
    │   ├── assets/
    │   └── views/
    ├── routes/
    ├── tests/
    └── module.json
```

## Gestione Dipendenze

### 1. File module.json
```json
{
    "name": "Patient",
    "alias": "patient",
    "description": "Gestione pazienti e ISEE",
    "keywords": [],
    "priority": 1,
    "active": 1,
    "order": 1,
    "providers": [
        "Modules\\Patient\\Providers\\PatientServiceProvider",
        "Modules\\Patient\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": [],
    "files": [],
    "requires": [
        "Xot",
        "User",
        "Media"
    ]
}
```

### 2. Dipendenze tra Moduli

#### Modulo Patient
- Dipende da:
  - Xot: per le funzionalità base
  - User: per la gestione degli utenti
  - Media: per la gestione dei documenti
  - Activity: per il logging delle attività

#### Modulo Dental
- Dipende da:
  - Xot: per le funzionalità base
  - Patient: per i dati dei pazienti
  - Media: per le immagini e i documenti
  - Activity: per il logging delle visite

#### Modulo ISEE
- Dipende da:
  - Xot: per le funzionalità base
  - Patient: per i dati dei pazienti
  - Media: per i documenti ISEE
  - Activity: per il logging delle modifiche

### 3. Service Provider
```php
namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

## Best Practices

### 1. Organizzazione
- Mantenere i moduli indipendenti
- Evitare dipendenze circolari
- Documentare chiaramente le dipendenze
- Utilizzare interfacce per le dipendenze

### 2. Naming
- PascalCase per i nomi dei moduli
- Seguire le convenzioni PSR-4
- Nomi descrittivi e significativi
- Namespace coerenti

### 3. Configurazione
- Pubblicare sempre i file di configurazione
- Utilizzare variabili d'ambiente
- Documentare le opzioni di configurazione
- Validare le configurazioni

### 4. Testing
- Test unitari per ogni modulo
- Test di integrazione per le dipendenze
- Test di feature per le funzionalità
- Coverage minimo 80%

## Note Importanti

### 1. Caricamento Moduli
- I moduli vengono caricati in ordine alfabetico
- Le dipendenze devono essere caricate prima
- Utilizzare il Service Provider per gestire l'ordine

### 2. Risorse Condivise
- Utilizzare il namespace `Modules\Shared`
- Evitare duplicazione di codice
- Documentare le risorse condivise
- Testare le risorse condivise

### 3. Migrazioni
- Versionare le migrazioni
- Testare le migrazioni
- Documentare le modifiche
- Gestire i rollback

### 4. Performance
- Ottimizzare le query
- Utilizzare il caching
- Monitorare le performance
- Documentare i colli di bottiglia 