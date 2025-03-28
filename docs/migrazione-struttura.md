# Migrazione della Struttura del Progetto SaluteOra

## Spostamento della Directory Laravel

Se l'installazione Laravel esiste già in una posizione errata, è possibile spostarla nella posizione corretta con un semplice comando:

```bash
# Spostare l'installazione Laravel dalla posizione errata a quella corretta
mv /var/www/html/saluteora/public_html/laravel /var/www/html/saluteora/laravel
```

Questo approccio è preferibile rispetto alla reinstallazione completa, in quanto:
- Preserva tutte le personalizzazioni già implementate
- Risparmia tempo e risorse
- Evita potenziali errori di configurazione
- Mantiene tutte le dipendenze già installate

## Struttura Corretta delle Directory

```
/var/www/html/saluteora/
├── docs/                     # Documentazione del progetto
├── laravel/                  # Installazione Laravel (posizione corretta)
│   ├── app/                  # Core application code
│   ├── bootstrap/            # Framework bootstrap files
│   ├── config/               # Configuration files
│   ├── database/             # Database migrations and seeds
│   ├── Modules/              # Moduli Laravel installati
│   └── ...                   # Altri file e directory Laravel
└── .cursor/                  # Configurazioni IDE
    └── rules/                # Regole per l'ambiente di sviluppo
```

## Aggiornamento Configurazioni

Dopo lo spostamento, potrebbe essere necessario aggiornare alcuni percorsi di file nelle configurazioni Laravel:

1. Verificare il file `.env` per eventuali percorsi assoluti
2. Aggiornare eventuali riferimenti nei file di configurazione
3. Aggiornare eventuali script di deployment

## Verifica Funzionamento

Per verificare che tutto funzioni correttamente dopo lo spostamento:

```bash
cd /var/www/html/saluteora/laravel
php artisan serve
```

Questo dovrebbe avviare il server di sviluppo Laravel senza errori se la migrazione ha avuto successo.
