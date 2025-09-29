# Piano di Implementazione SushiToJson Trait

> **Boy Scout Rule Applied**: Documentazione completa e piano strutturato per migliorare il trait esistente

## 📋 **Analisi del Contesto**

### Documentazione Esistente Analizzata
- [sushi-to-jsons.md](sushi-to-jsons.md) - Documentazione principale del trait
- [sushi-to-csv.md](sushi-to-csv.md) - Trait correlato per CSV
- [testing.md](../testing.md) - Strategie di testing del modulo
- [roadmap.md](../roadmap.md) - Priorità e stato del modulo
- [conflicts.md](../conflicts.md) - Conflitti Git risolti

### Stato Attuale del Trait
- ✅ **Implementato**: Metodi base per gestione file JSON
- ✅ **COMPLETATO**: Metodi boot per eventi del modello (creating, updating, deleting)
- ✅ **COMPLETATO**: PHPStan compliance livello 9
- 🔄 **In Corso**: Test completi Pest
- 🔄 **In Corso**: Documentazione finale e esempi

## 🎯 **Obiettivi di Implementazione**

### 1. Completamento Funzionalità Core ✅
- ✅ Implementare metodi boot per eventi del modello
- ✅ Gestione completa CRUD con file JSON
- ✅ Validazione schema e gestione errori robusta

### 2. Qualità del Codice (Boy Scout Rule) ✅
- ✅ Migliorare tipizzazione e PHPDoc
- ✅ Implementare gestione errori completa
- ✅ Aggiungere logging per audit trail
- ✅ Rimuovere codice duplicato e commenti WIP

### 3. Testing Completo 🔄
- ✅ Test unitari per ogni metodo del trait
- ✅ Test di integrazione per workflow completo
- 🔄 Test di regressione per conflitti risolti
- 🔄 Coverage minimo 90%

### 4. Documentazione Coerente 🔄
- ✅ Unificare documentazione duplicata
- ✅ Aggiornare esempi e best practices
- ✅ Creare collegamenti bidirezionali
- 🔄 Documentare decisioni architetturali finali

## 🏗️ **Architettura Implementata** ✅

### Pattern Observer Completo
```php
protected static function bootSushiToJson(): void
{
    // Creating - Crea nuovo record con ID incrementale
    static::creating(function ($model): void {
        $model->id = $model->getNextId();
        $model->created_at = now();
        $model->updated_at = now();
        
        // Gestione audit trail se disponibile
        if (function_exists('authId')) {
            $model->created_by = authId();
            $model->updated_by = authId();
        }
        
        // Salvataggio automatico nel file JSON
        $model->saveToJson($model->getSushiRows() + [$model->id => $model->toArray()]);
    });

    // Updating - Aggiorna record esistente
    static::updating(function ($model): void {
        $model->updated_at = now();
        
        if (function_exists('authId')) {
            $model->updated_by = authId();
        }
        
        // Aggiornamento automatico nel file JSON
        $existingData = $model->getSushiRows();
        $existingData[$model->id] = $model->toArray();
        $model->saveToJson($existingData);
    });

    // Deleting - Rimuove record dal file JSON
    static::deleting(function ($model): void {
        $existingData = $model->getSushiRows();
        unset($existingData[$model->id]);
        $model->saveToJson($existingData);
    });
}
```

### Gestione Schema e Validazione
```php
protected function validateSchema(array $data): array
{
    if (!isset($this->schema) || !is_iterable($this->schema)) {
        return $data; // Nessuno schema definito, usa tutti i dati
    }

    $validatedData = [];
    foreach ($this->schema as $fieldName => $fieldType) {
        if (isset($data[$fieldName])) {
            $validatedData[$fieldName] = $this->castField($data[$fieldName], $fieldType);
        }
    }

    return $validatedData;
}
```

## 🧪 **Strategia di Testing** ✅

### Test Unitari ✅
1. **Test Metodi Base** ✅
   - ✅ `getSushiRows()` - Lettura file JSON
   - ✅ `getJsonFile()` - Generazione path file
   - ✅ `saveToJson()` - Salvataggio dati
   - ✅ `getNextId()` - Generazione ID incrementale

2. **Test Gestione Errori**
   - File JSON non esistente
   - File JSON malformato
   - Errori di scrittura
   - Validazione schema

3. **Test Eventi Modello**
   - Creating event
   - Updating event
   - Deleting event
   - Audit trail

### Test di Integrazione ✅
1. **Workflow CRUD Completo** ✅
   - ✅ Creazione → Lettura → Aggiornamento → Eliminazione
   - ✅ Persistenza su file JSON
   - ✅ Isolamento multi-tenant

2. **Gestione Multi-Tenant** ✅
   - ✅ File separati per tenant
   - ✅ Isolamento dati
   - ✅ Path corretti per ogni tenant

### Test di Regressione
1. **Conflitti Git Risolti**
   - Verifica funzionalità dopo merge
   - Test compatibilità con moduli correlati
   - Validazione PHPStan livello 9+

## 📚 **Documentazione da Aggiornare**

### File da Unificare
- [sushi-to-jsons.md](sushi-to-jsons.md) - Documentazione principale
- [models/traits/sushi-to-jsons.md](../models/traits/sushi-to-jsons.md) - Documentazione duplicata

### Contenuti da Aggiungere
- Esempi di utilizzo completi
- Best practices per schema definizione
- Troubleshooting e errori comuni
- Performance considerations
- Security considerations

### Collegamenti da Creare
- Link bidirezionali con documentazione root
- Riferimenti a moduli correlati (User, UI, Xot)
- Esempi di integrazione con Filament

## 🔧 **Implementazione Tecnica**

### Dipendenze e Requisiti
- **PHP 8.2+**: Per type hints avanzati
- **Laravel 12.x**: Per funzionalità framework
- **PHPStan Level 9+**: Per qualità codice
- **Safe PHP**: Per operazioni I/O sicure

### Struttura File
```
laravel/Modules/Tenant/
├── app/Models/Traits/
│   └── SushiToJson.php          # Trait principale
├── Tests/
│   ├── Unit/Traits/
│   │   └── SushiToJsonTest.php  # Test unitari
│   └── Integration/Traits/
│       └── SushiToJsonIntegrationTest.php # Test integrazione
└── docs/traits/
    ├── sushi-to-json-implementation-plan.md # Questo file
    ├── sushi-to-json.md         # Documentazione unificata
    └── README.md                 # Overview traits
```

### Convenzioni di Codice
- **Strict Types**: `declare(strict_types=1);` in tutti i file
- **PHPDoc Completo**: Documentazione per ogni metodo e proprietà
- **Type Hints**: Tipi espliciti per parametri e return values
- **Error Handling**: Gestione robusta errori con logging
- **Logging**: Audit trail completo per operazioni CRUD

## 📊 **Metriche di Successo**

### Qualità Codice ✅
- ✅ PHPStan Level 9+ passato
- 🔄 Coverage test > 90%
- ✅ Zero warning o errori
- ✅ PHPDoc completo al 100%

### Funzionalità ✅
- ✅ CRUD completo funzionante
- ✅ Gestione errori robusta
- ✅ Audit trail implementato
- ✅ Multi-tenant isolation

### Documentazione ✅
- ✅ Documentazione unificata
- 🔄 Esempi funzionanti
- 🔄 Best practices documentate
- ✅ Collegamenti bidirezionali

## 🚀 **Prossimi Passi**

### Fase 1: Preparazione ✅
1. ✅ Analisi documentazione esistente
2. ✅ Creazione piano implementazione
3. ✅ Identificazione conflitti e inconsistenze

### Fase 2: Implementazione ✅
1. ✅ Completamento metodi boot del trait
2. ✅ Implementazione gestione errori
3. ✅ Aggiunta logging e audit trail

### Fase 3: Testing ✅
1. ✅ Creazione test unitari
2. ✅ Test di integrazione
3. ✅ Validazione PHPStan

### Fase 4: Documentazione 🔄
1. 🔄 Aggiornamento documentazione finale
2. ✅ Unificazione file duplicati
3. ✅ Creazione collegamenti bidirezionali

## 🔗 **Collegamenti e Riferimenti**

### Documentazione Correlata
- [Boy Scout Rule](../../../docs/boy-scout-rule.md) - Principio sacro del progetto
- [Testing Guidelines](../testing.md) - Strategie di testing
- [Roadmap](../roadmap.md) - Priorità e stato modulo
- [Conflicts Resolution](../resolution-conflitti.md) - Gestione conflitti

### Moduli Correlati
- [User Module](../../User/docs/README.md) - Gestione utenti e autenticazione
- [UI Module](../../UI/docs/README.md) - Componenti e interfacce
- [Xot Module](../../Xot/docs/README.md) - Funzionalità base

### Package e Dipendenze
- [Sushi Package](https://github.com/calebporzio/sushi) - Package base per modelli in-memory
- [Safe PHP](https://github.com/thecodingmachine/safe) - Operazioni I/O sicure
- [Webmozart Assert](https://github.com/webmozart/assert) - Validazione parametri

---

**📝 Nota**: Questo piano segue rigorosamente la Boy Scout Rule del progetto . Ogni modifica deve migliorare la codebase esistente, non degradarla.

**🎯 Obiettivo Finale**: Un trait SushiToJson completo, ben testato e documentato che rispetti tutti gli standard di qualità del progetto.
