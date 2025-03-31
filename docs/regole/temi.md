# Regole per la Gestione dei Temi

## Struttura Base
- I temi devono essere nella directory `Themes`
- Ogni tema deve avere una struttura standard
- Il tema predefinito deve essere configurato

## Struttura Directory
```
Themes/
└── One/
    ├── resources/
    │   └── views/
    │       ├── layouts/
    │       ├── pages/
    │       └── components/
    ├── assets/
    │   ├── css/
    │   ├── js/
    │   └── images/
    └── config/
        └── theme.php
```

## Configurazione
```php
// config/theme.php
return [
    'name' => 'One',
    'description' => 'Tema predefinito SaluteOra',
    'active' => true,
    'views_path' => 'Themes/One/resources/views',
    'assets_path' => 'Themes/One/assets',
];
```

## Validazione
- Verificare che la directory del tema esista
- Controllare che tutti i file necessari siano presenti
- Assicurarsi che i percorsi siano corretti
- Verificare che il tema sia registrato nel service provider 