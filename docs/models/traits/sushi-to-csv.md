# SushiToCsv Trait Documentation

## Overview
Il trait `SushiToCsv` estende il trait Sushi per fornire funzionalità di persistenza dei dati su file CSV per i modelli Laravel.

## Funzionalità

### Gestione File CSV
- Lettura e scrittura automatica da/su file CSV
- Gestione automatica degli header
- Supporto per operazioni CRUD

### Metodi Principali
- `getSushiRows()`: Recupera tutti i record dal file CSV
- `getCsvPath()`: Ottiene il percorso del file CSV
- `getCsvHeader()`: Recupera gli header del CSV

### Eventi Gestiti
1. **Creating**
   - Generazione automatica ID
   - Impostazione timestamp
   - Tracciamento utente creatore
   - Inserimento nuovo record

2. **Updating**
   - Aggiornamento timestamp
   - Tracciamento utente modificatore
   - Aggiornamento record esistente

3. **Deleting**
   - Rimozione record
   - Riscrittura file CSV

## Utilizzo
```php
class MyModel extends Model
{
    use SushiToCsv;

    protected $table = 'my_table';
}
```

## Dipendenze
- League/CSV per la gestione dei file CSV
- Sushi trait per l'integrazione con Eloquent
- TenantService per la gestione dei percorsi

## Recent Changes
- Rimossi conflitti di merge
- Migliorata la gestione degli ID
- Aggiunto supporto per soft delete
- Ottimizzata la gestione della memoria 