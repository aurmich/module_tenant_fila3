# Autenticazione con Filament

## Overview
Utilizziamo l'autenticazione integrata di Filament 3.x, che fornisce un sistema completo di gestione utenti, ruoli e permessi. Il sistema è stato configurato per rispettare le normative GDPR e supportare un'architettura multi-tenant.

## Setup Iniziale

### 1. Installazione Filament
```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

### 2. Configurazione Autenticazione
```php
// config/filament.php
return [
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => \Filament\Pages\Auth\Login::class,
        ],
    ],
    'middleware' => [
        'base' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Modules\Tenant\Http\Middleware\TenantMiddleware::class,
            \Modules\Gdpr\Http\Middleware\GdprComplianceMiddleware::class,
        ],
        'auth' => [
            \Filament\Http\Middleware\Authenticate::class,
        ],
    ],
];
```

### 3. Setup Spatie Permissions
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 4. Configurazione Activity Logging
```bash
# Per tracciare tutte le attività degli utenti (GDPR)
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"
php artisan migrate
```

## Struttura Multi-Tenant

### 1. Modello User con Multi-Tenant
```php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Activity\Traits\LogsActivity;
use Modules\Gdpr\Traits\CanBeErased;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles, BelongsToTenant, LogsActivity, CanBeErased;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'gdpr_consented_at',
        'terms_accepted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'gdpr_consented_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
    ];

    // Log delle attività per GDPR
    protected static $logAttributes = ['name', 'email', 'tenant_id'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function canAccessPanel(Panel $panel): bool
    {
        // Controllo per accesso pannello di amministrazione
        if ($panel->getId() === 'admin') {
            return $this->hasAnyRole(['admin', 'super_admin']);
        }

        // Controllo per accesso pannello medico
        if ($panel->getId() === 'doctor') {
            return $this->hasRole('doctor');
        }

        // Controllo per accesso pannello assistente
        if ($panel->getId() === 'assistant') {
            return $this->hasRole('assistant');
        }

        return false;
    }

    // Metodo per GDPR - Anonimizzazione dati
    public function anonymize(): void
    {
        $this->update([
            'name' => 'Utente cancellato',
            'email' => 'deleted_' . $this->id . '@example.com',
            // Mantenere tenant_id per motivi di reporting
        ]);
    }
}
```

### 2. Ruoli e Permessi Multi-Tenant
```php
// database/seeders/RoleSeeder.php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\Tenant\Models\Tenant;

public function run()
{
    // Ruoli globali (non specifici del tenant)
    $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
    
    // Per ogni tenant, creiamo ruoli specifici
    $tenants = Tenant::all();
    
    foreach ($tenants as $tenant) {
        // Prefisso tenant per i ruoli tenant-specific
        $prefix = "tenant_{$tenant->id}_";
        
        // Creazione Ruoli per tenant
        $admin = Role::create(['name' => $prefix . 'admin', 'guard_name' => 'web']);
        $doctor = Role::create(['name' => $prefix . 'doctor', 'guard_name' => 'web']);
        $assistant = Role::create(['name' => $prefix . 'assistant', 'guard_name' => 'web']);
        $patient = Role::create(['name' => $prefix . 'patient', 'guard_name' => 'web']);
        
        // Creazione Permessi
        $permissions = [
            $prefix . 'view_patients',
            $prefix . 'create_patients',
            $prefix . 'edit_patients',
            $prefix . 'delete_patients',
            $prefix . 'view_visits',
            $prefix . 'create_visits',
            $prefix . 'edit_visits',
            $prefix . 'delete_visits',
            $prefix . 'view_isee',
            $prefix . 'create_isee',
            $prefix . 'edit_isee',
            $prefix . 'delete_isee',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        
        // Assegnazione Permessi ai Ruoli
        $admin->givePermissionTo(Permission::where('name', 'like', $prefix . '%')->get());
        
        $doctor->givePermissionTo([
            $prefix . 'view_patients',
            $prefix . 'create_patients',
            $prefix . 'edit_patients',
            $prefix . 'view_visits',
            $prefix . 'create_visits',
            $prefix . 'edit_visits',
            $prefix . 'view_isee',
            $prefix . 'create_isee',
            $prefix . 'edit_isee',
        ]);
        
        $assistant->givePermissionTo([
            $prefix . 'view_patients',
            $prefix . 'create_patients',
            $prefix . 'view_visits',
            $prefix . 'create_visits',
            $prefix . 'view_isee',
        ]);
        
        $patient->givePermissionTo([
            $prefix . 'view_patients',
            $prefix . 'view_visits',
            $prefix . 'view_isee',
        ]);
    }
    
    // Il super_admin ha tutti i permessi
    $superAdmin->givePermissionTo(Permission::all());
}
```

### 3. Pannelli Filament Multi-Tenant
```php
namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Blade;
use Modules\Tenant\Models\Tenant;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \Modules\Tenant\Http\Middleware\TenantMiddleware::class,
                \Modules\Gdpr\Http\Middleware\GdprComplianceMiddleware::class,
            ])
            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ])
            ->tenant(Tenant::class, slugAttribute: 'slug')
            ->tenantProfile(Modules\Tenant\Filament\Pages\EditTenantProfile::class)
            ->tenantMenu()
            ->spa();
    }
}

class DoctorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('doctor')
            ->path('doctor')
            ->login()
            ->colors([
                'primary' => Color::Sky,
            ])
            // ... altre configurazioni
            ->tenant(Tenant::class, slugAttribute: 'slug')
            ->tenantProfile(Modules\Tenant\Filament\Pages\EditTenantProfile::class)
            ->tenantMenu();
    }
}
```

## Integrazione GDPR

### 1. Gestione Consensi
```php
namespace Modules\Gdpr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gdpr\Models\Consent;
use Carbon\Carbon;

class GdprController extends Controller
{
    public function showConsentForm()
    {
        return view('gdpr::consent');
    }
    
    public function updateConsent(Request $request)
    {
        $validated = $request->validate([
            'privacy_policy' => 'required|boolean',
            'marketing' => 'boolean',
            'analytics' => 'boolean',
        ]);
        
        // Registrare il consenso con timestamp
        $user = auth()->user();
        $user->update([
            'gdpr_consented_at' => Carbon::now(),
        ]);
        
        // Salvare i dettagli del consenso
        Consent::updateOrCreate(
            ['user_id' => $user->id],
            [
                'privacy_policy' => $validated['privacy_policy'],
                'marketing' => $validated['marketing'] ?? false,
                'analytics' => $validated['analytics'] ?? false,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );
        
        return redirect()->back()->with('success', 'Le tue preferenze sono state aggiornate.');
    }
    
    public function export(Request $request)
    {
        $user = auth()->user();
        
        // Generare export dati in formato JSON
        $data = [
            'user' => $user->toArray(),
            'visits' => $user->visits->toArray(),
            'consents' => $user->consents->toArray(),
            'activities' => $user->activities->toArray(),
        ];
        
        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="personal-data-export.json"',
        ]);
    }
    
    public function delete(Request $request)
    {
        $user = auth()->user();
        
        // Anonimizzare invece di cancellare completamente
        $user->anonymize();
        
        // Logout
        auth()->logout();
        
        return redirect('/')->with('success', 'Il tuo account è stato anonimizzato.');
    }
}
```

### 2. Middleware GDPR
```php
namespace Modules\Gdpr\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GdprComplianceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Bypass per alcune rotte (login, register, consent)
        $bypassRoutes = [
            'login', 'register', 'gdpr.consent', 'logout',
            'privacy-policy', 'terms-of-service',
        ];
        
        foreach ($bypassRoutes as $route) {
            if ($request->routeIs($route)) {
                return $next($request);
            }
        }
        
        // Verificare se l'utente ha dato il consenso GDPR
        if (Auth::check() && !Auth::user()->gdpr_consented_at) {
            return redirect()->route('gdpr.consent')
                ->with('warning', 'Per continuare, è necessario accettare la nostra Privacy Policy.');
        }
        
        return $next($request);
    }
}
```

## Best Practices

### 1. Sicurezza
- **HTTPS obbligatorio**
  ```php
  // app/Providers/AppServiceProvider.php
  public function boot()
  {
      if (app()->environment('production')) {
          URL::forceScheme('https');
      }
  }
  ```

- **Rate Limiting**
  ```php
  // routes/web.php
  Route::middleware(['web', 'throttle:60,1'])->group(function () {
      // Rotte pubbliche
  });
  
  Route::middleware(['web', 'throttle:5,1'])->group(function () {
      // Rotte di login/autenticazione
  });
  ```

- **Validazione Input**
  ```php
  // Esempio di regole di validazione per form paziente
  $rules = [
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,'.$user->id,
      'password' => [
          'sometimes',
          'confirmed',
          Password::min(12)
              ->mixedCase()
              ->letters()
              ->numbers()
              ->symbols()
              ->uncompromised(),
      ],
  ];
  ```

- **Sanitizzazione Output**
  ```php
  // Configura Laravel-Purifier
  composer require mews/purifier
  
  // Nelle viste Blade
  {!! Purifier::clean($content) !!}
  ```

### 2. Performance
- **Query Optimization**
  ```php
  // Utilizzare eager loading per evitare N+1 query
  $patients = Patient::with(['visits', 'documents'])->where('tenant_id', $tenantId)->get();
  ```

- **Caching**
  ```php
  // cache/redis.php
  'tenant_prefix' => true, // Per isolare le cache per ogni tenant
  
  // Nel codice
  $cacheKey = "tenant:{$tenantId}:patient:{$patientId}";
  $patient = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($patientId) {
      return Patient::with(['visits', 'treatments'])->findOrFail($patientId);
  });
  ```

- **Lazy Loading**
  ```php
  // Usare il lazy loading solo quando necessario
  use Illuminate\Database\Eloquent\Builder;
  
  Patient::addGlobalScope('tenant', function (Builder $builder) {
      if (auth()->check()) {
          $builder->where('tenant_id', auth()->user()->tenant_id);
      }
  });
  ```

- **Monitoraggio Performance**
  ```php
  // Utilizzare Laravel Telescope in development
  composer require laravel/telescope --dev
  
  // In produzione, New Relic o simili
  ```

### 3. UX
- **Feedback Immediato**
  ```php
  <x-filament::notification :notification="Notification::make()
      ->title('Salvato!')
      ->body('Il paziente è stato aggiornato con successo.')
      ->success()
      ->send()"
  />
  ```

- **Messaggi di Errore Chiari**
  ```php
  // In caso di errore
  return back()->withErrors([
      'email' => 'Non è stato possibile verificare le tue credenziali.',
  ])->withInput();
  ```

- **Conferme per Azioni Critiche**
  ```php
  // In Filament
  Action::make('delete')
      ->requiresConfirmation()
      ->modalHeading('Eliminare il paziente?')
      ->modalDescription('Sei sicuro di voler eliminare questo paziente? L\'operazione non può essere annullata.')
      ->modalSubmitActionLabel('Sì, elimina')
      ->modalCancelActionLabel('No, annulla')
  ```

- **Navigazione Intuitiva**
  ```php
  // Nel pannello Filament
  ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
      return $builder
          ->items([
              NavigationItem::make('Dashboard')
                  ->icon('heroicon-o-home')
                  ->activeIcon('heroicon-s-home')
                  ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard')),
              // ...
          ])
          ->groups([
              NavigationGroup::make('Pazienti')
                  ->items([
                      // ...
                  ]),
              // ...
          ]);
  })
  ```

### 4. Testing
- **Test di Autenticazione**
  ```php
  // tests/Feature/Auth/LoginTest.php
  public function test_users_can_authenticate_using_the_login_screen()
  {
      $user = User::factory()->create();
  
      $response = $this->post('/login', [
          'email' => $user->email,
          'password' => 'password',
      ]);
  
      $this->assertAuthenticated();
      $response->assertRedirect(RouteServiceProvider::HOME);
  }
  ```

- **Test di Autorizzazione**
  ```php
  // tests/Feature/PatientAccessTest.php
  public function test_doctor_can_view_patient_details()
  {
      $tenant = Tenant::factory()->create();
      $user = User::factory()->doctor()->forTenant($tenant)->create();
      $patient = Patient::factory()->forTenant($tenant)->create();
  
      $this->actingAs($user)
          ->get("/patients/{$patient->id}")
          ->assertStatus(200)
          ->assertSee($patient->name);
  }
  
  public function test_assistant_cannot_delete_patient()
  {
      $tenant = Tenant::factory()->create();
      $user = User::factory()->assistant()->forTenant($tenant)->create();
      $patient = Patient::factory()->forTenant($tenant)->create();
  
      $this->actingAs($user)
          ->delete("/patients/{$patient->id}")
          ->assertStatus(403);
  }
  ```

## Note Importanti

### 1. Sessioni
- Configurare correttamente il driver delle sessioni con Redis per più server
- Gestire timeout sessioni per sicurezza
- Implementare "Remember Me" con token sicuri
- Scadenza sessioni dopo un periodo di inattività

### 2. Password
- Politica password robusta (lunghezza, complessità)
- Reset password sicuro con token a scadenza
- Supporto per 2FA tramite TOTP
- Notifiche per cambio password

### 3. Logging
- Log delle attività utente come richiesto dal GDPR
- Log degli errori per debug rapido
- Log di sicurezza per tentativi di accesso sospetti
- Monitoraggio in tempo reale

### 4. Backup e Recovery
- Backup automatici giornalieri del database
- Backup incrementali dei file
- Procedure documentate per disaster recovery
- Test periodici di ripristino 