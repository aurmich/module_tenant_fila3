# Gestione della Homepage di SaluteOra

## Struttura e Modifica Corretta

La homepage del portale SaluteOra è gestita attraverso un file JSON che definisce i blocchi di contenuto visualizzati. Per modificare la homepage è necessario intervenire sul seguente file:

```
/var/www/html/saluteora/laravel/config/local/saluteora/database/content/pages/1.json
```

### Struttura del file JSON

Il file JSON della homepage ha la seguente struttura:

```json
{
    "id": "1",
    "title": {
        "it": "SaluteOra - Promozione della salute orale per le gestanti"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            // Qui sono definiti i blocchi di contenuto
            // Ogni blocco ha un "type" e dei "data" specifici
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null
}
```

### Tipi di blocchi disponibili

I blocchi attualmente implementati includono:

1. **hero** - Banner principale con titolo, sottotitolo e immagine
2. **feature_sections** - Sezioni con caratteristiche del servizio
3. **stats** - Statistiche del progetto
4. **cta** - Call to action

### Come modificare la homepage

Per modificare la homepage, è necessario:

1. Identificare il blocco che si desidera modificare nel file JSON
2. Aggiornare i valori nei campi "data" del blocco
3. Aggiungere nuovi blocchi se necessario, seguendo la struttura esistente

### Esempio di modifica per aggiornare il testo principale

Per aggiornare il testo principale della homepage con il testo ufficiale:

```json
{
    "type": "text_block",
    "data": {
        "view": "ui::components.blocks.text.v1",
        "content": "Benvenuta su Salute Orale,\n\nil portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito.\n\nSe sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:",
        "alignment": "left",
        "background_color": "bg-white",
        "text_color": "text-gray-900"
    }
}
```

### Esempio di modifica per aggiungere un pulsante "INIZIA ORA"

```json
{
    "type": "cta",
    "data": {
        "view": "ui::components.blocks.cta.v1",
        "title": "",
        "description": "",
        "button_text": "INIZIA ORA",
        "button_link": "/register",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "button_color": "bg-indigo-600 hover:bg-indigo-700"
    }
}
```

## Analisi dell'Errore Commesso

### Errore identificato

Nell'approccio precedente, ho commesso un errore fondamentale: ho proposto modifiche concettuali all'interfaccia utente senza considerare l'architettura tecnica del sistema SaluteOra. Ho ignorato completamente che:

1. I contenuti sono gestiti tramite file JSON strutturati
2. Esiste un percorso specifico per questi file (`/laravel/config/local/saluteora/database/content/`)
3. La modifica deve avvenire rispettando la struttura dei blocchi esistenti

### Cause dell'errore

1. **Mancata analisi dell'architettura**: Non ho esaminato come i contenuti vengono effettivamente gestiti nel sistema
2. **Approccio superficiale**: Ho proposto modifiche generiche senza considerare l'implementazione tecnica
3. **Ignoranza del pattern di gestione dei contenuti**: Non ho considerato che SaluteOra utilizza un sistema di gestione dei contenuti basato su JSON

### Come evitare questo errore in futuro

1. **Analizzare sempre la struttura dei dati**: Prima di proporre modifiche, esaminare come i contenuti sono strutturati e gestiti
2. **Verificare i file di configurazione**: Controllare i file JSON nella directory `/laravel/config/local/saluteora/database/content/`
3. **Rispettare la struttura dei blocchi**: Utilizzare i tipi di blocchi esistenti o crearne di nuovi seguendo lo stesso pattern
4. **Testare le modifiche**: Dopo aver modificato i file JSON, verificare che le modifiche siano visualizzate correttamente

## Regola Fondamentale

> **IMPORTANTE**: In SaluteOra, i contenuti delle pagine sono gestiti tramite file JSON nella directory `/laravel/config/local/saluteora/database/content/`. Qualsiasi modifica ai contenuti deve essere effettuata modificando questi file, rispettando la struttura dei blocchi esistenti. Non proporre mai modifiche concettuali senza considerare l'implementazione tecnica sottostante.
