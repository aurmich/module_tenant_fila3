# Estensione Modulo User con Funzionalità Avanzate

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

L'estensione del modulo User con funzionalità avanzate è attualmente completata all'85%. Questo modulo è cruciale per gestire l'autenticazione, l'autorizzazione e la profilazione degli utenti all'interno della piattaforma SaluteOra.

## Obiettivi dell'Implementazione

L'estensione del modulo User mira a:

1. Implementare un sistema completo di ruoli e permessi granulari
2. Gestire profili utente avanzati con dati estesi
3. Supportare autenticazione multi-fattore (MFA)
4. Personalizzare l'esperienza utente in base al profilo
5. Integrare le funzionalità di audit trail per tracciare le azioni
6. Migliorare la sicurezza complessiva del sistema di autenticazione

## Componenti Implementati (85%)

- ✅ Sistema base di autenticazione con Laravel Fortify
- ✅ Gestione ruoli e permessi con Spatie Permission
- ✅ Profili utente estesi con informazioni personali e professionali
- ✅ Integrazione multi-tenant per utenti
- ✅ Gestione password con policy di sicurezza
- ✅ Recupero password e verifica email
- ✅ Preferenze utente personalizzabili
- ✅ Log delle azioni utente principali

## Componenti da Implementare (15%)

- 🚧 Autenticazione multi-fattore (MFA) (50%)
- 🚧 Sistema avanzato di audit delle azioni utente (60%)
- 🚧 Implementazione OAuth2 per Single Sign-On (40%)
- 🚧 Personalizzazione dashboard per ruolo utente (70%)
- 📅 API di gestione utenti completa
- 📅 Sistema di inviti e registrazione gestita

## Architettura del Modulo User

Il modulo User è strutturato secondo un'architettura modulare che separa autenticazione, profili, ruoli e audit:

```
┌─────────────────┐       ┌─────────────────┐       ┌─────────────────┐
│                 │       │                 │       │                 │
│  Auth Module    │◄─────►│  User Core      │◄─────►│  Profile Module │
│                 │       │                 │       │                 │
└─────────────────┘       └───────┬─────────┘       └─────────────────┘
                                  │
                    ┌─────────────┼─────────────┐
                    │             │             │
          ┌─────────▼─────┐ ┌─────▼─────┐ ┌─────▼─────┐
          │               │ │           │ │           │
          │  Role & Perm  │ │  Audit    │ │  Settings │
          │  Module       │ │  Module   │ │  Module   │
          │               │ │           │ │           │
          └───────────────┘ └───────────┘ └───────────┘
```

## Modello dei Dati

### User

```php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasProfilePhoto, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'active',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'settings' => 'array',
    ];

    // Relazioni
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
    
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function auditLogs()
    {
        return $this->hasMany(UserAuditLog::class);
    }
    
    // ...
}
```

### UserProfile

```php
class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'language',
        'timezone',
        'birth_date',
        'fiscal_code',
        'professional_role',
        'department',
        'specialization',
        'bio',
    ];
    
    protected $casts = [
        'birth_date' => 'date',
        'custom_fields' => 'array',
    ];
    
    // ...
}
```

## Sistema di Ruoli e Permessi

Il sistema utilizza Spatie Permission con customizzazioni per supportare il multi-tenant:

```php
// Definizione ruoli di base
$roles = [
    'super-admin' => 'Amministratore di Sistema',
    'admin' => 'Amministratore Tenant',
    'manager' => 'Manager',
    'doctor' => 'Medico',
    'nurse' => 'Infermiere',
    'receptionist' => 'Receptionist',
    'patient' => 'Paziente',
    'guest' => 'Ospite',
];

// Esempio di permessi per modulo Dental
$permissions = [
    'dental.appointments.view',
    'dental.appointments.create',
    'dental.appointments.edit',
    'dental.appointments.delete',
    'dental.treatments.view',
    'dental.treatments.create',
    'dental.treatments.edit',
    'dental.treatments.delete',
    // ...
];

// Assegnazione permessi ai ruoli
$rolePermissions = [
    'doctor' => [
        'dental.appointments.view',
        'dental.appointments.create',
        'dental.appointments.edit',
        'dental.treatments.view',
        'dental.treatments.create',
        'dental.treatments.edit',
    ],
    // ...
];
```

## Autenticazione Multi-fattore

L'implementazione MFA in corso utilizza Laravel Fortify con personalizzazioni:

```php
// config/fortify.php
'features' => [
    Features::registration(),
    Features::resetPasswords(),
    Features::emailVerification(),
    Features::updateProfileInformation(),
    Features::updatePasswords(),
    Features::twoFactorAuthentication([
        'confirmPassword' => true,
    ]),
],
```

## Sistema di Audit

Il sistema di audit traccia le azioni degli utenti:

```php
class UserAuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];
    
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
    
    // ...
}
```

L'audit è integrato attraverso un trait che può essere aggiunto ai modelli:

```php
trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::logAction($model, 'created');
        });
        
        static::updated(function ($model) {
            self::logAction($model, 'updated');
        });
        
        static::deleted(function ($model) {
            self::logAction($model, 'deleted');
        });
    }
    
    protected static function logAction($model, $action)
    {
        if (!auth()->check()) {
            return;
        }
        
        UserAuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'entity_type' => get_class($model),
            'entity_id' => $model->getKey(),
            'description' => self::getActionDescription($model, $action),
            'old_values' => $action === 'created' ? [] : $model->getOriginal(),
            'new_values' => $model->getAttributes(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
    
    // ...
}
```

## Interfaccia Amministrativa

L'interfaccia di gestione utenti in Filament consente:

1. **Gestione Utenti**:
   - Creazione, modifica, disattivazione
   - Reset password
   - Assegnazione ruoli e permessi

2. **Gestione Ruoli**:
   - Creazione e modifica ruoli
   - Assegnazione permessi
   - Visualizzazione utenti per ruolo

3. **Monitoraggio Attività**:
   - Log accessi
   - Azioni recenti
   - Filtri avanzati

## Sicurezza

La sicurezza è garantita attraverso:

1. **Protezione Password**:
   - Hashing bcrypt con cost factor elevato
   - Validazione complessità password
   - Prevenzione riutilizzo password recenti

2. **Protezione Account**:
   - Blocco account dopo tentativi falliti
   - Rate limiting sulle API di autenticazione
   - Rilevamento accessi sospetti

3. **Impersonation Controllata**:
   - Per supporto tecnico
   - Con tracciamento completo
   - Con limitazioni di permessi

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Autenticazione MFA | Maggio 2024 | Alta |
| Sistema audit avanzato | Maggio 2024 | Alta |
| OAuth2 SSO | Giugno 2024 | Media |
| Dashboard per ruolo | Maggio 2024 | Alta |
| API gestione utenti | Luglio 2024 | Media |
| Sistema inviti | Luglio 2024 | Bassa |

## Metriche di Successo

- Tempo di risposta autenticazione < 300ms
- Copertura permessi 100%
- Riduzione incidenti sicurezza > 90%
- Soddisfazione utenti > 4.5/5
