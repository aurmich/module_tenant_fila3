# Linee Guida per la Documentazione di SaluteOra

Questo documento definisce le best practices per la creazione e la manutenzione della documentazione all'interno del progetto SaluteOra.

## Struttura della Documentazione

### 1. Organizzazione dei File

La documentazione dovrebbe essere organizzata in modo coerente in tutti i moduli e nella directory principale:

```
/var/www/html/saluteora/
├── docs/                  # Documentazione principale del progetto
│   ├── README.md          # Panoramica e punto d'ingresso
│   ├── moduli.md          # Descrizione dettagliata dei moduli
│   ├── struttura/         # Documentazione sulla struttura
│   ├── implementazione/   # Documentazione di implementazione
│   └── regole/            # Regole e linee guida
│
└── laravel/Modules/[ModuleName]/
    ├── docs/              # Documentazione ufficiale del modulo
    │   ├── README.md      # Panoramica e punto d'ingresso
    │   ├── components/    # Documentazione dei componenti
    │   └── assets/        # Immagini, diagrammi e altri assets
    │
    └── _docs/             # Note, appunti e documenti in fase di sviluppo
        ├── topic1.txt     # Appunti su un argomento specifico
        ├── links.txt      # Collegamenti utili
        └── ...            # Altri appunti
```

### 2. Nomenclatura dei File

Per garantire coerenza e facilità di navigazione:

- File principali: utilizzare lowercase con trattini (es. `linee-guida-documentazione.md`)
- File per cartelle specifiche: utilizzare lowercase con trattini (es. `getting-started.md`)
- File di appunti: utilizzare lowercase con underscore (es. `api_notes.txt`)
- File specifici del modulo: prefix `module_` seguito dal nome del modulo in minuscolo (es. `module_patient.md`)

## Formato dei Documenti

### 1. Frontmatter (opzionale)

Per i documenti che potrebbero essere utilizzati da un generatore di siti statici, iniziare con un frontmatter YAML:

```markdown
---
title: Titolo del Documento
description: Breve descrizione del contenuto
extends: _layouts.documentation
section: content
---
```

### 2. Intestazione e Introduzione

Ogni documento dovrebbe iniziare con:

```markdown
# Titolo Principale {#ancora-opzionale}

Breve introduzione che spiega lo scopo del documento e il contesto.
```

### 3. Struttura delle Sezioni

Utilizzare una gerarchia chiara di intestazioni:

```markdown
## Sezione Principale {#sezione-principale}

Descrizione della sezione principale.

### Sottosezione {#sottosezione}

Contenuto dettagliato della sottosezione.

#### Ulteriore dettaglio

Contenuto ancora più specifico.
```

### 4. Blocchi di Codice

Per gli esempi di codice, specificare sempre il linguaggio:

````markdown
```php
// Esempio di codice PHP
public function example(): string
{
    return 'Hello World';
}
```
````

### 5. Note e Avvisi

Utilizzare formati standard per note e avvisi:

```markdown
> **Nota**: Informazione aggiuntiva o chiarimento.

⚠️ **ATTENZIONE**: Avviso importante che richiede particolare attenzione.
```

## Manutenzione della Documentazione

### 1. Aggiornamento

- Aggiornare la documentazione contestualmente alle modifiche del codice
- Revisionare periodicamente la documentazione per verificarne l'accuratezza
- Indicare la data dell'ultimo aggiornamento per i documenti critici

### 2. Versionamento

- Mantenere la documentazione allineata con le versioni del software
- Utilizzare tag o branch per documentazione specifica di versioni

### 3. Review

- Effettuare peer review della documentazione
- Verificare l'accuratezza tecnica
- Controllare la chiarezza e la completezza

## Lingue

La documentazione principale deve essere in italiano. Per documenti con versioni in più lingue:

- Utilizzare sottocartelle per lingua (es. `/docs/en/` per inglese)
- Mantenere coerenza tra le versioni in diverse lingue
- Indicare chiaramente la lingua principale e le traduzioni disponibili

## Link e Riferimenti

- Utilizzare link relativi per documenti interni
- Utilizzare link assoluti per risorse esterne
- Verificare periodicamente i link per assicurarsi che funzionino

## Esempi

- Includere esempi pratici dove possibile
- Fornire casi d'uso reali
- Spiegare il contesto dell'esempio

## Diagrammi e Immagini

- Salvare i diagrammi in formato SVG quando possibile
- Fornire testo alternativo per le immagini
- Mantenere i diagrammi aggiornati con il codice
- Utilizzare nomi descrittivi per i file immagine 