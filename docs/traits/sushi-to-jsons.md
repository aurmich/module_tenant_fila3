# SushiToJsons Trait

Il trait SushiToJsons estende le funzionalità di Sushi per gestire i dati dei modelli utilizzando file JSON come sorgente dati.

## Caratteristiche principali

- Integrazione con il package Sushi per l'accesso ai dati
- Gestione automatica di file JSON come sorgente dati
- Supporto per schema di dati personalizzato
- Gestione automatica di timestamp e utenti per le modifiche

## Metodi principali

### `getSushiRows(): array`
Recupera i dati dai file JSON nella directory del tenant e li converte in un array di record secondo lo schema definito.

### `getJsonFile(): string`
Determina il percorso del file JSON per un record specifico basato sulla tabella e l'ID.

## Eventi gestiti

### Creating
- Genera automaticamente l'ID incrementale
- Imposta i timestamp di creazione e aggiornamento
- Registra l'utente che ha creato il record
- Valida e converte i dati secondo lo schema
- Crea il file JSON con i dati formattati

### Updating
- Aggiorna i timestamp
- Registra l'utente che ha modificato il record
- Aggiorna il file JSON con i nuovi dati

### Deleting
- Rimuove il file JSON associato al record

## Schema dei dati

Il trait richiede la definizione di uno schema nel modello che lo utilizza:

```php
protected $schema = [
    'nome_campo' => 'tipo',
    // ...
];
```

## Best Practices

- Definire sempre uno schema completo per i dati
- Validare i dati prima del salvataggio
- Gestire correttamente le directory dei tenant
- Implementare la gestione degli errori per le operazioni di I/O

## Dipendenze

- `sushi`: Per il comportamento base del modello
- `webmozart/assert`: Per la validazione dei parametri
- `safe`: Per operazioni sicure su JSON

## Esempio di utilizzo

```php
use Modules\Tenant\Models\Traits\SushiToJsons;

class MyModel extends Model
{
    use SushiToJsons;

    protected $table = 'my_table';
    
    protected $schema = [
        'name' => 'string',
        'data' => 'array',
        'active' => 'boolean'
    ];
}
``` 