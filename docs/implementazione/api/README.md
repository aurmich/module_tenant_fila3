# API SaluteOra

## Panoramica
Le API di SaluteOra forniscono un'interfaccia RESTful per l'integrazione con sistemi esterni, applicazioni mobile e servizi di terze parti.

## Autenticazione

### Token Authentication
```php
// config/sanctum.php
return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,127.0.0.1')),
    'expiration' => 60 * 24 * 7, // 7 giorni
    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
];
```

### Login
```
POST /api/auth/login

{
    "email": "user@example.com",
    "password": "password",
    "device_name": "iPhone 13"
}

Response:
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
        "id": 1,
        "name": "User Name",
        "email": "user@example.com",
        "tenant_id": 1,
        "roles": ["doctor"]
    }
}
```

### Autorizzazione
```php
// routes/api.php
Route::middleware(['auth:sanctum', 'tenant'])->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    
    // Routes solo per ruoli specifici
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/stats', [AdminController::class, 'stats']);
    });
});
```

## Endpoints Principali

### Pazienti
| Metodo | Endpoint                         | Descrizione                     | Ruoli           |
|--------|----------------------------------|----------------------------------|-----------------|
| GET    | `/api/patients`                  | Lista pazienti                   | doctor, assistant|
| GET    | `/api/patients/{patient}`        | Dettaglio paziente               | doctor, assistant|
| POST   | `/api/patients`                  | Crea paziente                    | doctor, assistant|
| PUT    | `/api/patients/{patient}`        | Aggiorna paziente                | doctor, assistant|
| DELETE | `/api/patients/{patient}`        | Elimina paziente                 | doctor          |
| GET    | `/api/patients/{patient}/isee`   | ISEE paziente                    | doctor, assistant|
| POST   | `/api/patients/{patient}/isee`   | Registra ISEE                    | doctor, assistant|

### Appuntamenti
| Metodo | Endpoint                           | Descrizione                     | Ruoli           |
|--------|------------------------------------|----------------------------------|-----------------|
| GET    | `/api/appointments`                | Lista appuntamenti               | all             |
| GET    | `/api/appointments/{appointment}`  | Dettaglio appuntamento           | all             |
| POST   | `/api/appointments`                | Crea appuntamento                | doctor, assistant|
| PUT    | `/api/appointments/{appointment}`  | Aggiorna appuntamento            | doctor, assistant|
| DELETE | `/api/appointments/{appointment}`  | Elimina appuntamento             | doctor, assistant|
| PUT    | `/api/appointments/{appointment}/status` | Aggiorna stato             | doctor, assistant|

### Trattamenti
| Metodo | Endpoint                          | Descrizione                       | Ruoli           |
|--------|-----------------------------------|-----------------------------------|-----------------|
| GET    | `/api/treatments`                 | Lista trattamenti                 | all             |
| GET    | `/api/treatments/{treatment}`     | Dettaglio trattamento             | all             |
| POST   | `/api/treatments`                 | Crea trattamento                  | admin           |
| PUT    | `/api/treatments/{treatment}`     | Aggiorna trattamento              | admin           |
| GET    | `/api/patients/{patient}/treatments` | Trattamenti paziente           | doctor, assistant|
| POST   | `/api/treatment-plans`            | Crea piano terapeutico            | doctor          |
| PUT    | `/api/treatment-plans/{plan}`     | Aggiorna piano terapeutico        | doctor          |

### Reports
| Metodo | Endpoint                              | Descrizione                     | Ruoli           |
|--------|------------------------------------|----------------------------------|-----------------|
| GET    | `/api/reports/dashboard`            | Dati dashboard                   | admin, manager  |
| GET    | `/api/reports/patient/{patient}`    | Report paziente                  | doctor, manager |
| GET    | `/api/reports/revenue`              | Report ricavi                    | admin, manager  |
| GET    | `/api/reports/treatments`           | Report trattamenti               | admin, manager  |
| GET    | `/api/reports/export/patient/{patient}` | Export report paziente        | doctor, manager |

## Request e Response

### PatientRequest
```php
namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'fiscal_code' => ['required', 'string', 'max:16', 'regex:/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i'],
            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F,O'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'region' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive,archived'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
```

### PatientResource
```php
namespace Modules\Patient\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'fiscal_code' => $this->fiscal_code,
            'birth_date' => $this->birth_date->format('Y-m-d'),
            'birth_place' => $this->birth_place,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'region' => $this->region,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'notes' => $this->notes,
            'current_isee' => $this->when($this->relationLoaded('isee'), function () {
                return $this->currentIsee 
                    ? new IseeResource($this->currentIsee) 
                    : null;
            }),
            'has_active_treatment_plan' => $this->whenLoaded('treatmentPlans', function () {
                return $this->treatmentPlans->contains(function ($plan) {
                    return $plan->status !== TreatmentPlanStatus::COMPLETED &&
                           $plan->status !== TreatmentPlanStatus::CANCELLED;
                });
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
```

## Middleware

### TenantMiddleware

```php
namespace Modules\Tenant\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Tenant\Services\TenantManager;

class TenantApiMiddleware
{
    protected TenantManager $tenantManager;
    
    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }
    
    public function handle(Request $request, Closure $next)
    {
        // Identifica tenant dal dominio o header
        $tenantId = $request->header('X-Tenant-ID');
        
        if ($tenantId) {
            $this->tenantManager->setTenantById($tenantId);
        } else {
            // Usa tenant dall'utente autenticato
            $user = $request->user();
            
            if ($user && $user->tenant_id) {
                $this->tenantManager->setTenantById($user->tenant_id);
            } else {
                return response()->json([
                    'message' => 'Tenant non specificato',
                ], 400);
            }
        }
        
        return $next($request);
    }
}
```

## Rate Limiting

```php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // ... altro codice ...
    
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(20)->by($request->ip());
        });
        
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
```

## Documentazione API

### Swagger Configuration
```php
/**
 * @OA\Info(
 *     title="SaluteOra API",
 *     version="1.0.0",
 *     description="API per il sistema SaluteOra",
 *     @OA\Contact(
 *         email="support@saluteora.it"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="https://api.saluteora.it/v1",
 *     description="Production Server"
 * )
 * 
 * @OA\Server(
 *     url="https://staging-api.saluteora.it/v1",
 *     description="Staging Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
```

### Esempio Definizione API
```php
/**
 * @OA\Get(
 *     path="/patients",
 *     summary="Ottieni lista pazienti",
 *     tags={"Patients"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Numero di risultati per pagina",
 *         @OA\Schema(type="integer", default=15)
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Numero di pagina",
 *         @OA\Schema(type="integer", default=1)
 *     ),
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Testo di ricerca",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista pazienti",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Patient")),
 *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta"),
 *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorizzato"
 *     )
 * )
 */
```

## Testing API

### Feature Test
```php
namespace Modules\Patient\Tests\Feature;

use Tests\TestCase;
use Modules\Patient\Models\Patient;
use Modules\Tenant\Models\Tenant;
use Modules\User\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_authenticated_user_can_get_patients_list()
    {
        // Setup
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['tenant_id' => $tenant->id]);
        $user->assignRole('doctor');
        
        Patient::factory()->count(3)->create(['tenant_id' => $tenant->id]);
        
        // Authentication
        Sanctum::actingAs($user, ['*']);
        
        // Action
        $response = $this->getJson('/api/patients');
        
        // Assertions
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'full_name',
                        'fiscal_code',
                        'email',
                        'phone',
                    ]
                ],
                'meta',
                'links'
            ]);
    }
}
```

## Strategie di Caching

### Cache per Risorse
```php
namespace Modules\Patient\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Xot\Http\Controllers\BaseController;
use Modules\Patient\Models\Patient;
use Modules\Patient\Http\Resources\PatientResource;
use Illuminate\Support\Facades\Cache;

class PatientController extends BaseController
{
    public function index(Request $request)
    {
        $user = $request->user();
        $tenantId = $user->tenant_id;
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);
        
        $cacheKey = "patients:tenant:{$tenantId}:page:{$page}:perPage:{$perPage}";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
            $patients = Patient::query()
                ->latest()
                ->paginate($perPage);
                
            return PatientResource::collection($patients);
        });
    }
}
```

## Webhook

### Configurazione
```php
// config/webhook.php
return [
    'endpoints' => [
        'patient_created' => [
            'url' => env('WEBHOOK_PATIENT_CREATED_URL'),
            'secret' => env('WEBHOOK_PATIENT_CREATED_SECRET'),
        ],
        'appointment_created' => [
            'url' => env('WEBHOOK_APPOINTMENT_CREATED_URL'),
            'secret' => env('WEBHOOK_APPOINTMENT_CREATED_SECRET'),
        ],
    ],
    'retries' => 3,
    'timeout' => 5,
];
```

### Invio Webhook
```php
namespace Modules\Patient\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Patient\Models\Patient;

class PatientCreated
{
    use Dispatchable, SerializesModels;
    
    public Patient $patient;
    
    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }
    
    public function broadcastAs()
    {
        return 'patient.created';
    }
    
    public function broadcastWith()
    {
        return [
            'id' => $this->patient->id,
            'tenant_id' => $this->patient->tenant_id,
            'full_name' => $this->patient->full_name,
            'created_at' => $this->patient->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
``` 