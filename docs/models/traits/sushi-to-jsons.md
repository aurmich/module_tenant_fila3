# SushiToJsons Trait Documentation

## Overview
Il trait `SushiToJsons` estende il trait Sushi per fornire funzionalità di persistenza dei dati su file JSON per i modelli Laravel.

## Funzionalità

### Gestione File JSON
- Lettura e scrittura automatica da/su file JSON individuali
- Supporto per schema di dati personalizzato
- Gestione automatica della directory di storage

### Metodi Principali
- `getSushiRows()`: Recupera tutti i record dai file JSON
- `getJsonFile()`: Ottiene il percorso del file JSON per un record specifico

### Schema Dati
```php
protected $schema = [
    'field_name' => 'field_type',
    // ...
];
```

### Eventi Gestiti
1. **Creating**
   - Generazione automatica ID
   - Impostazione timestamp
   - Tracciamento utente creatore
   - Creazione file JSON
   - Validazione schema

2. **Updating**
   - Aggiornamento timestamp
   - Tracciamento utente modificatore
   - Aggiornamento file JSON

3. **Deleting**
   - Rimozione file JSON

## Utilizzo
```php
class MyModel extends Model
{
    use SushiToJsons;

    protected $table = 'my_table';
    protected $schema = [
        'name' => 'string',
        'age' => 'integer',
    ];
}
```

## Dipendenze
- Sushi trait per l'integrazione con Eloquent
- TenantService per la gestione dei percorsi
- Safe PHP per operazioni JSON sicure

## Recent Changes
- Rimossi conflitti di merge
- Aggiunta validazione dello schema
- Migliorata la gestione degli errori
- Ottimizzata la gestione della memoria 