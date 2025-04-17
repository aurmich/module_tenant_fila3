# SushiToCsv Trait

Il trait SushiToCsv estende le funzionalità di Sushi per gestire i dati dei modelli utilizzando file CSV come sorgente dati.

## Caratteristiche principali

- Integrazione con il package Sushi per l'accesso ai dati
- Gestione automatica di file CSV come sorgente dati
- Supporto per operazioni CRUD sui dati
- Gestione automatica di timestamp e utenti per le modifiche

## Metodi principali

### `getSushiRows(): array`
Recupera i dati dal file CSV e li converte in un array di record.

### `getCsvPath(): string`
Determina il percorso del file CSV basato sul nome della tabella del modello.

### `getCsvHeader(): array`
Recupera l'intestazione (nomi delle colonne) dal file CSV.

## Eventi gestiti

### Creating
- Genera automaticamente l'ID incrementale
- Imposta i timestamp di creazione e aggiornamento
- Registra l'utente che ha creato il record
- Aggiunge il nuovo record al file CSV

### Updating
- Aggiorna i timestamp
- Registra l'utente che ha modificato il record
- Aggiorna il record nel file CSV mantenendo la struttura esistente

### Deleting
- Rimuove il record dal file CSV
- Mantiene l'integrità dei dati rimanenti

## Best Practices

- Utilizzare `Assert` per validare i parametri critici
- Mantenere la consistenza dei dati tra il modello e il file CSV
- Gestire correttamente le intestazioni del CSV
- Implementare la gestione degli errori per le operazioni di I/O

## Dipendenze

- `league/csv`: Per la gestione dei file CSV
- `sushi`: Per il comportamento base del modello
- `webmozart/assert`: Per la validazione dei parametri

## Esempio di utilizzo

```php
use Modules\Tenant\Models\Traits\SushiToCsv;

class MyModel extends Model
{
    use SushiToCsv;

    protected $table = 'my_table';
}
``` 