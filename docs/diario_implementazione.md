# Diario di Implementazione Progetto SaluteOra

Questo documento contiene il diario dettagliato dell'implementazione del progetto SaluteOra, registrando ogni passo, decisione, problema e soluzione incontrati durante lo sviluppo.

## Formato delle Registrazioni

Ogni registrazione segue il formato:

```
## [Data] - [Titolo dell'Attività]

### Attività
Descrizione dettagliata dell'attività svolta.

### Comandi Eseguiti
```bash
comando1
comando2
```

### Risultati
Risultati ottenuti dall'attività.

### Problemi Incontrati
Eventuali problemi o ostacoli incontrati.

### Soluzioni Applicate
Come sono stati risolti i problemi.

### Lezioni Apprese
Cosa abbiamo imparato da questo passo.
```

---

## 28/03/2024 - Inizio Implementazione e Setup Ambiente

### Attività
Oggi iniziamo l'implementazione del progetto SaluteOra. Il primo passo è la preparazione dell'ambiente di sviluppo e l'installazione di Laravel e Laravel Modules.

### 1. Installazione di Laravel Installer

#### Comando Eseguito
```bash
composer global require laravel/installer
```

#### Risultato
```
Changed current directory to /home/zorin/.config/composer
./composer.json has been updated
Running composer update laravel/installer
Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Writing lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating autoload files
36 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
No security vulnerability advisories found.
Using version ^5.14 for laravel/installer
```

Laravel Installer era già installato nel sistema, quindi non sono state necessarie modifiche. Stiamo utilizzando la versione 5.14 di Laravel Installer.

#### Lezioni Apprese
- È importante verificare se gli strumenti necessari sono già installati prima di procedere
- Composer gestisce automaticamente le dipendenze e mantiene informazioni sulle versioni utilizzate

### 2. Correzione del percorso di installazione di Laravel

#### Problema riscontrato
Ho inizialmente tentato di creare il progetto Laravel nella directory `/var/www/html/saluteora/public_html/laravel`, che è un percorso errato. Secondo le specifiche del progetto, il progetto Laravel deve essere posizionato direttamente in `/var/www/html/saluteora/laravel`.

#### Analisi dell'errore
Questo errore è stato causato da una comprensione errata della struttura del progetto SaluteOra. Ho erroneamente pensato che il codice dovesse risiedere in una directory `public_html`, che è un pattern comune in alcuni hosting web ma non è richiesto in questo progetto.

#### Soluzione ottimizzata
Una soluzione efficiente sarebbe spostare la directory già creata nella posizione corretta utilizzando il comando `mv`:

```bash
mv /var/www/html/saluteora/public_html/laravel /var/www/html/saluteora/laravel
```

#### Verifica della soluzione
Ho verificato se la directory `public_html/laravel` esiste per poterla spostare:

```bash
if [ -d "/var/www/html/saluteora/public_html/laravel" ]; then 
    mv /var/www/html/saluteora/public_html/laravel /var/www/html/saluteora/laravel && echo "Directory moved successfully" || echo "Move failed"
else 
    echo "Source directory doesn't exist"
fi
```

Risultato:
```
Source directory doesn't exist
```

Questo indica che la directory di origine non esiste, probabilmente perché il processo di creazione del progetto Laravel nel percorso sbagliato non è stato completato. Poiché non c'è nulla da spostare, dovremo procedere con la creazione del progetto Laravel direttamente nella posizione corretta.

#### Lezioni apprese
- Quando possibile, preferire operazioni di spostamento/rinomina anziché ricreare da zero
- I comandi di sistema come `mv` sono utili per correggere rapidamente errori di struttura delle directory
- È importante verificare l'esistenza di file/directory prima di tentare operazioni su di essi
- In caso di fallimento di un'operazione, è fondamentale verificare lo stato attuale del sistema prima di procedere

### 3. Creazione del progetto Laravel nel percorso corretto

Ho tentato di creare il progetto Laravel nella posizione corretta:

```bash
cd /var/www/html/saluteora && laravel new laravel
```

Risultato:
```
   _                               _
  | |                             | |
  | |     __ _ _ __ __ ___   _____| |
  | |    / _` |  __/ _` \ \ / / _ \ |
  | |___| (_| | | | (_| |\ V /  __/ |
  |______\__,_|_|  \__,_| \_/ \___|_|


In NewCommand.php line 735:
                               
  Application already exists!  
                               
```

Ho verificato il contenuto della directory principale:

```bash
ls -la /var/www/html/saluteora
```

E ho scoperto che la directory `laravel` è già presente. Questo è un risultato positivo, poiché possiamo procedere direttamente con i passaggi successivi dell'implementazione senza dover creare un nuovo progetto Laravel.

#### Lezione appresa
- È fondamentale verificare sempre lo stato attuale del filesystem prima di eseguire operazioni
- A volte i problemi che pensiamo di risolvere potrebbero già essere stati risolti in passato
- Iniziare sempre con un controllo delle risorse esistenti per evitare duplicazioni di lavoro

### 4. Installazione di Laravel Modules

Ora che abbiamo confermato l'esistenza della directory Laravel, procediamo con l'installazione di Laravel Modules.

#### 4.1 Configurazione dei plugin di Composer

Prima di installare Laravel Modules, abbiamo dovuto configurare Composer per consentire il plugin `wikimedia/composer-merge-plugin`, che è necessario per Laravel Modules e per l'integrazione dei composer.json dei vari moduli:

```bash
cd /var/www/html/saluteora/laravel && composer config allow-plugins.wikimedia/composer-merge-plugin true
```

Questo comando è stato eseguito con successo, abilitando il plugin richiesto nella configurazione di Composer.

#### 4.2 Installazione di Laravel Modules

Dopo aver configurato il permesso per il plugin, abbiamo installato Laravel Modules:

```bash
composer require nwidart/laravel-modules
```

Risultato:
```
./composer.json has been updated
Running composer update nwidart/laravel-modules
Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Writing lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.  

  laravel/pail ...................................................................................... DONE
  laravel/sail ...................................................................................... DONE
  laravel/tinker .................................................................................... DONE
  livewire/flux ..................................................................................... DONE
  livewire/livewire ................................................................................. DONE
  livewire/volt ..................................................................................... DONE
  nesbot/carbon ..................................................................................... DONE
  nunomaduro/collision .............................................................................. DONE
  nunomaduro/termwind ............................................................................... DONE
  nwidart/laravel-modules ........................................................................... DONE
  pestphp/pest-plugin-laravel ....................................................................... DONE

89 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
> @php artisan vendor:publish --tag=laravel-assets --ansi --force

   INFO  No publishable resources for tag [laravel-assets].  

No security vulnerability advisories found.
Using version ^12.0 for nwidart/laravel-modules
```

Laravel Modules è stato installato con successo nella versione ^12.0, che è compatibile con Laravel 11.

#### Lezioni apprese
- Quando si lavora con pacchetti Composer che includono plugin, è necessario configurare esplicitamente i permessi per questi plugin
- È importante controllare le versioni dei pacchetti per assicurarsi che siano compatibili con la versione di Laravel in uso
- Composer tiene traccia delle dipendenze nel file di lock, quindi anche se un pacchetto risulta già installato, il comando `composer require` può essere usato per assicurarsi che sia nella configurazione

### 5. Pubblicazione dei file di configurazione di Laravel Modules

Il prossimo passo è pubblicare i file di configurazione di Laravel Modules:

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

Risultato:
```
   INFO  Publishing assets.  

  Copying file [vendor/nwidart/laravel-modules/config/config.php] to [config/modules.php] ........... DONE
  Copying directory [vendor/nwidart/laravel-modules/src/Commands/stubs] to [stubs/nwidart-stubs] .... DONE
  Copying file [vendor/nwidart/laravel-modules/scripts/vite-module-loader.js] to [vite-module-loader.js]  DONE
```

Questo comando ha pubblicato con successo:
1. Il file di configurazione `config/modules.php`
2. Gli stubs per la generazione di nuovi moduli in `stubs/nwidart-stubs`
3. Un loader Vite per i moduli in `vite-module-loader.js`

Questi file ci permetteranno di personalizzare comportamenti come:
- Il percorso in cui verranno archiviati i moduli
- I namespace utilizzati per i moduli
- I percorsi per i diversi tipi di file all'interno dei moduli
- Le opzioni di scansione e caricamento dei moduli

#### Lezioni apprese
- La pubblicazione dei file di configurazione è un passaggio importante perché permette di personalizzare il comportamento del pacchetto
- Gli stubs pubblicati possono essere modificati per personalizzare la generazione di nuovi moduli secondo le necessità del progetto
- L'integrazione con Vite è inclusa, il che facilita la gestione degli asset frontend nei moduli

### 6. Configurazione del composer.json per l'autoloading dei moduli

Per garantire il corretto funzionamento dei moduli, dobbiamo configurare composer.json per l'autoloading dei namespace dei moduli. Sebbene Laravel Modules possa creare automaticamente i namespace dei moduli, è buona pratica configurare esplicitamente l'autoloading in composer.json per una migliore integrazione.

#### 6.1 Verifica della configurazione esistente

Prima di tutto, abbiamo verificato il contenuto attuale di composer.json:

```bash
cat composer.json
```

Dall'output abbiamo notato che:
1. Il namespace `Modules\` non era presente nella sezione `autoload.psr-4`
2. La configurazione `merge-plugin` non era presente nella sezione `extra`

#### 6.2 Aggiornamento del composer.json

Abbiamo modificato il file composer.json per aggiungere le configurazioni necessarie:

1. Aggiunto il namespace `Modules\` nella sezione `autoload.psr-4`:
   ```json
   "autoload": {
       "psr-4": {
           "App\\": "app/",
           "Database\\Factories\\": "database/factories/",
           "Database\\Seeders\\": "database/seeders/",
           "Modules\\": "Modules/"
       }
   }
   ```

2. Aggiunto la configurazione `merge-plugin` nella sezione `extra`:
   ```json
   "extra": {
       "laravel": {
           "dont-discover": []
       },
       "merge-plugin": {
           "include": [
               "Modules/*/composer.json"
           ],
           "recurse": true,
           "replace": false,
           "ignore-duplicates": false,
           "merge-dev": true,
           "merge-extra": false,
           "merge-extra-deep": false,
           "merge-scripts": false
       }
   }
   ```

#### 6.3 Installazione di wikimedia/composer-merge-plugin

Poiché abbiamo configurato l'uso del plugin merge-plugin, abbiamo dovuto installarlo esplicitamente:

```bash
composer require wikimedia/composer-merge-plugin
```

Risultato:
```
./composer.json has been updated
Running composer update wikimedia/composer-merge-plugin
Loading composer repositories with package information
Updating dependencies
Nothing to modify in lock file
Writing lock file
Installing dependencies from lock file (including require-dev)
Nothing to install, update or remove
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.  

  laravel/pail ...................................................................................... DONE
  laravel/sail ...................................................................................... DONE
  laravel/tinker .................................................................................... DONE
  livewire/flux ..................................................................................... DONE
  livewire/livewire ................................................................................. DONE
  livewire/volt ..................................................................................... DONE
  nesbot/carbon ..................................................................................... DONE
  nunomaduro/collision .............................................................................. DONE
  nunomaduro/termwind ............................................................................... DONE
  nwidart/laravel-modules ........................................................................... DONE
  pestphp/pest-plugin-laravel ....................................................................... DONE

89 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
> @php artisan vendor:publish --tag=laravel-assets --ansi --force

   INFO  No publishable resources for tag [laravel-assets].  

No security vulnerability advisories found.
Using version ^2.1 for wikimedia/composer-merge-plugin
```

Il plugin wikimedia/composer-merge-plugin è stato installato con successo nella versione ^2.1.

#### 6.4 Aggiornamento dell'autoloader

Infine, abbiamo aggiornato l'autoloader di Composer per applicare le modifiche:

```bash
composer dump-autoload
```

Risultato:
```
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi

   INFO  Discovering packages.  

  laravel/pail ...................................................................................... DONE
  laravel/sail ...................................................................................... DONE
  laravel/tinker .................................................................................... DONE
  livewire/flux ..................................................................................... DONE
  livewire/livewire ................................................................................. DONE
  livewire/volt ..................................................................................... DONE
  nesbot/carbon ..................................................................................... DONE
  nunomaduro/collision .............................................................................. DONE
  nunomaduro/termwind ............................................................................... DONE
  nwidart/laravel-modules ........................................................................... DONE
  pestphp/pest-plugin-laravel ....................................................................... DONE

Generated optimized autoload files containing 7294 classes
```

L'autoloader è stato generato con successo, includendo ora il supporto per il namespace `Modules\`.

#### Lezioni apprese
- È importante configurare esplicitamente l'autoloading per i moduli nel composer.json
- Il plugin wikimedia/composer-merge-plugin è necessario per integrare i composer.json dei vari moduli
- Dopo modifiche al composer.json, è sempre necessario eseguire `composer dump-autoload` per applicare le modifiche

### 7. Creazione del modulo Patient

Il prossimo passo è creare il primo modulo custom: Patient. Questo modulo gestirà i pazienti, le loro informazioni e i documenti ISEE associati.

Per creare il modulo, utilizzeremo il comando artisan fornito da Laravel Modules:

```bash
php artisan module:make Patient
```

Risultato:
```
   INFO  Creating module: [Patient].  

  Generating file Modules/Patient/module.json ................................................ 0.16ms DONE
  Generating file Modules/Patient/routes/web.php ............................................. 1.67ms DONE
  Generating file Modules/Patient/routes/api.php ............................................. 0.12ms DONE
  Generating file Modules/Patient/resources/views/index.blade.php ............................ 0.08ms DONE
  Generating file Modules/Patient/resources/views/layouts/master.blade.php ................... 0.27ms DONE
  Generating file Modules/Patient/config/config.php .......................................... 0.08ms DONE
  Generating file Modules/Patient/composer.json .............................................. 0.12ms DONE
  Generating file Modules/Patient/resources/assets/js/app.js ................................. 0.22ms DONE
  Generating file Modules/Patient/resources/assets/sass/app.scss ............................. 0.19ms DONE
  Generating file Modules/Patient/vite.config.js ............................................. 0.09ms DONE
  Generating file Modules/Patient/package.json ............................................... 0.08ms DONE
  Generating file Modules/Patient/database/seeders/PatientDatabaseSeeder.php ................. 0.85ms DONE
  Generating file Modules/Patient/app/Providers/PatientServiceProvider.php ................... 0.08ms DONE
  Generating file Modules/Patient/app/Providers/EventServiceProvider.php ..................... 0.10ms DONE
  Generating file Modules/Patient/app/Providers/RouteServiceProvider.php ..................... 0.07ms DONE
  Generating file Modules/Patient/app/Http/Controllers/PatientController.php ................. 0.07ms DONE

   INFO  Module [Patient] created successfully.
```

Il comando ha creato con successo la struttura base del modulo Patient in `Modules/Patient`. Abbiamo verificato la struttura delle directory generate:

```bash
ls -la Modules/Patient
```

Risultato:
```
total 48
drwxr-xr-x 8 zorin zorin 4096 Mar 28 10:44 .
drwxr-xr-x 3 zorin zorin 4096 Mar 28 10:44 ..
drwxr-xr-x 4 zorin zorin 4096 Mar 28 10:44 app
-rw-r--r-- 1 zorin zorin  658 Mar 28 10:44 composer.json
drwxr-xr-x 2 zorin zorin 4096 Mar 28 10:44 config
drwxr-xr-x 5 zorin zorin 4096 Mar 28 10:44 database
-rw-r--r-- 1 zorin zorin  217 Mar 28 10:44 module.json
-rw-r--r-- 1 zorin zorin  264 Mar 28 10:44 package.json
drwxr-xr-x 4 zorin zorin 4096 Mar 28 10:44 resources
drwxr-xr-x 2 zorin zorin 4096 Mar 28 10:44 routes
drwxr-xr-x 4 zorin zorin 4096 Mar 28 10:44 tests
-rw-r--r-- 1 zorin zorin 1758 Mar 28 10:44 vite.config.js
```

#### 7.1 Verifica della configurazione del modulo

Abbiamo controllato il file `module.json` del modulo Patient:

```bash
cat Modules/Patient/module.json
```

Risultato:
```json
{
    "name": "Patient",
    "alias": "patient",
    "description": "",
    "keywords": [],
    "priority": 0,
    "providers": [
        "Modules\\Patient\\Providers\\PatientServiceProvider"
    ],
    "files": []
}
```

Questo file necessita di modifiche per adattarsi alle esigenze del progetto, in particolare:
- Aggiungere una descrizione
- Impostare una priorità adeguata
- Specificare le dipendenze (requires) del modulo

#### 7.2 Verifica del Service Provider

Abbiamo anche esaminato il Service Provider generato:

```bash
cat Modules/Patient/app/Providers/PatientServiceProvider.php
```

Questo file attualmente estende `Illuminate\Support\ServiceProvider`, ma dovrà essere modificato per estendere `Modules\Xot\Providers\XotBaseServiceProvider` una volta che il modulo Xot sarà importato.

#### 7.3 Riflessione sull'ordine di implementazione

Dopo aver creato il modulo Patient, mi sono reso conto che avremmo dovuto seguire un ordine diverso nell'implementazione. Il modulo Patient estenderà classi dal modulo Xot e avrà dipendenze da altri moduli Laraxot, ma questi moduli non sono ancora stati importati nel progetto.

**Approccio corretto**:
1. Importare prima i moduli Laraxot tramite git subtree
2. Solo successivamente creare i moduli custom (dopo l'importazione dei moduli Laraxot)

Questa sequenza avrebbe permesso di:
- Estendere direttamente `XotBaseServiceProvider` nel Service Provider
- Configurare correttamente le dipendenze nel `module.json`
- Evitare refactoring successivi del modulo

#### Lezioni apprese
- È fondamentale pianificare accuratamente l'ordine di implementazione dei moduli
- I moduli base (come Xot) devono essere importati prima di creare moduli che dipendono da essi
- Seguire un approccio "top-down" nelle dipendenze riduce la necessità di refactoring

### 8. Verifica dello stato del repository Git

Prima di procedere con l'importazione dei moduli Laraxot, ho verificato lo stato attuale del repository Git:

```bash
cd /var/www/html/saluteora && git status
```

Risultato:
```
On branch dev

No commits yet

Untracked files:
  (use "git add <file>..." to include in what will be committed)
        .cursor/
        .gitattributes
        .gitignore
        .windsurfrules
        README.md
        docs/
        laravel/
        public_html/

nothing added to commit but untracked files present (use "git add" to track)
```

Il repository è nel branch `dev` ma non ha ancora nessun commit. Ci sono diversi file non tracciati, tra cui la directory `laravel/` che contiene il nostro progetto Laravel. Prima di procedere con l'importazione dei moduli Laraxot tramite git subtree, è necessario eseguire un commit iniziale per avere un punto di partenza pulito.

#### Lezioni apprese
- È importante verificare lo stato del repository Git prima di procedure con operazioni complesse come l'importazione tramite git subtree
- Un repository senza commit iniziali può causare problemi quando si tenta di utilizzare funzionalità Git avanzate
- La struttura del repository deve essere ben organizzata prima di iniziare l'importazione di moduli esterni

### 9. Commit iniziale del repository

Ho eseguito il commit iniziale di tutti i file del progetto:

```bash
cd /var/www/html/saluteora && git add . && git commit -m "chore: initial commit"
```

Risultato:
```
[dev (root-commit) 241d509] chore: initial commit
 314 files changed, 34870 insertions(+)
 ... [elenco dei file aggiunti] ...
```

Questo commit iniziale fornisce un punto di partenza solido per l'importazione dei moduli Laraxot tramite git subtree.

### 10. Revisione dell'approccio di implementazione

Dopo aver analizzato la situazione attuale, abbiamo identificato la necessità di rivedere l'approccio di implementazione. Nel documento `docs/ordine_implementazione.md` abbiamo dettagliato l'ordine corretto per l'implementazione dei moduli:

1. Setup base del progetto (già completato)
2. Importazione dei moduli Laraxot esistenti tramite git subtree (prossimo passo)
3. Creazione dei moduli custom (dopo l'importazione dei moduli Laraxot)
4. Configurazione dei moduli custom

Poiché abbiamo già creato il modulo Patient, dovremo:
1. Eliminare il modulo Patient esistente o
2. Modificare il modulo esistente dopo l'importazione dei moduli Laraxot

La seconda opzione è probabilmente preferibile, poiché la struttura di base del modulo è già stata creata. Tuttavia, sarà necessario modificare il Service Provider per estendere `XotBaseServiceProvider` e aggiornare il file `module.json` per includere le dipendenze corrette.

### Prossimi Passi

1. **Importazione dei moduli core Laraxot tramite git subtree:**
   - Importare prima il modulo Xot, che è il modulo base per tutti gli altri
   - Seguire con l'importazione di altri moduli core (User, Media, Activity, Lang, Tenant, GDPR)
   - Configurare correttamente i prefissi per le importazioni

2. **Configurazione dei moduli importati:**
   - Verificare la compatibilità delle versioni
   - Risolvere eventuali conflitti

3. **Refactoring del modulo Patient esistente:**
   - Modificare il Service Provider per estendere XotBaseServiceProvider
   - Aggiornare module.json per includere le dipendenze corrette

4. **Creazione del modulo Dental:**
   - Creare il modulo dopo l'importazione dei moduli Laraxot
   - Configurare correttamente fin dall'inizio

## Potenziali Colli di Bottiglia e Strategie di Mitigazione

### 1. Dimensione dei repository Laraxot
I repository dei moduli Laraxot potrebbero essere di grandi dimensioni, rendendo l'importazione tramite git subtree un processo lungo e potenzialmente soggetto a errori.

**Strategia di mitigazione:**
- Utilizzare l'opzione `--squash` per git subtree per ridurre la dimensione dell'importazione
- Pianificare l'importazione in batch, iniziando dai moduli essenziali
- Verificare la connessione di rete e la disponibilità di banda sufficiente

### 2. Conflitti durante l'importazione
Potrebbero verificarsi conflitti durante l'importazione dei moduli, specialmente se ci sono file con lo stesso nome o percorso.

**Strategia di mitigazione:**
- Pianificare l'ordine di importazione in base alle dipendenze
- Prepararsi a risolvere manualmente i conflitti se necessario
- Mantenere un backup del repository prima di iniziare l'importazione

### 3. Compatibilità delle versioni
I moduli Laraxot potrebbero essere progettati per versioni diverse di Laravel o altre dipendenze.

**Strategia di mitigazione:**
- Verificare la compatibilità dei moduli con la versione di Laravel in uso (Laravel 11)
- Preparare un piano per gestire potenziali incompatibilità
- Identificare e documentare le modifiche necessarie per garantire la compatibilità

### 4. Capacità di storage e risorse di sistema
L'importazione di molti moduli può richiedere una quantità significativa di spazio su disco e risorse di sistema.

**Strategia di mitigazione:**
- Verificare lo spazio disponibile prima di iniziare l'importazione
- Monitorare l'utilizzo delle risorse durante il processo
- Considerare l'esecuzione in momenti di basso carico del sistema 