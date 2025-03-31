# Traduzioni in SaluteOra

## Principi Fondamentali

La gestione delle traduzioni in SaluteOra segue un approccio strutturato e automatizzato attraverso il `LangServiceProvider`. Questo documento descrive le best practices e le regole da seguire per garantire una corretta localizzazione dell'applicazione.

### Regola #1: MAI utilizzare ->label()

```php
// ❌ NON FARE MAI QUESTO
TextInput::make('nome')->label('Nome Utente')
```

Il metodo `->label()` non deve mai essere utilizzato direttamente nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider` che intercetta la creazione dei componenti e applica le traduzioni appropriate.

### Struttura dei File di Traduzione

Utilizzare sempre la struttura espansa per i campi nei file di traduzione:

```php
// resources/lang/it/resource.php
return [
    'fields' => [
        'nome_campo' => [
            'label' => 'Etichetta Campo',
            'tooltip' => 'Descrizione di aiuto per il campo',
            'placeholder' => 'Esempio di input'
        ],
    ],
];
```

Utilizzare la struttura espansa anche per le azioni:

```php
return [
    'actions' => [
        'nome_azione' => [
            'label' => 'Etichetta Azione',
            'icon' => 'heroicon-name',
            'color' => 'primary|secondary|success|danger',
            'tooltip' => 'Descrizione dell\'azione'
        ],
    ],
];
```

### Convenzioni di Naming

Seguire queste convenzioni per le chiavi di traduzione:

- Utilizzare il formato `modulo::risorsa.fields.campo.label`
- Mantenere coerenza tra le diverse lingue
- Utilizzare nomi descrittivi e significativi

## Come Funziona il Sistema di Traduzione

Il `LangServiceProvider` intercetta la creazione dei componenti Filament e applica automaticamente le traduzioni appropriate basandosi sulla struttura dei file di traduzione. Questo processo è gestito dalla classe `AutoLabelAction` che determina la chiave di traduzione corretta per ogni componente.

Quando un componente viene creato, il sistema:

1. Determina il contesto del componente (classe, modulo, etc.)
2. Genera una chiave di traduzione appropriata
3. Cerca la traduzione corrispondente nei file di lingua
4. Applica automaticamente l'etichetta al componente

## Vantaggi dell'Approccio

- **Coerenza**: Tutte le etichette seguono lo stesso formato e stile
- **Manutenibilità**: Le traduzioni sono centralizzate e facili da aggiornare
- **Automazione**: Nessun bisogno di specificare manualmente le etichette
- **Supporto multilingua**: Facile aggiunta di nuove lingue

## Troubleshooting

### Etichette Mancanti

Se un'etichetta non viene visualizzata correttamente:

1. Verificare che il file di traduzione esista e contenga la chiave corretta
2. Controllare che il `LangServiceProvider` sia registrato correttamente
3. Assicurarsi di non aver utilizzato il metodo `->label()` che sovrascrive il comportamento automatico

### Etichette con Prefisso "FIX:"

Se un'etichetta appare con il prefisso "FIX:" (es. "FIX:module::resource.fields.name.label"), significa che la chiave di traduzione non è stata trovata. Aggiungere la traduzione mancante nel file di lingua appropriato.