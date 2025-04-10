# Testing SaluteOra

## Strategia di Testing

### Livelli
- Unit Testing
- Feature Testing
- Integration Testing
- Browser Testing
- Performance Testing

### Coverage
- Minimo 80% coverage
- Critical paths: 100%
- Edge cases: 100%
- Error handling: 100%
- Security: 100%

## Unit Testing

### Models
```php
class PatientTest extends TestCase
{
    /** @test */
    public function it_calculates_isee_correctly()
    {
        $patient = Patient::factory()->create([
            'income' => 15000,
            'family_size' => 3
        ]);

        $this->assertEquals(5000, $patient->calculateIsee());
    }
}
```

### Services
```php
class DentalServiceTest extends TestCase
{
    /** @test */
    public function it_schedules_appointment()
    {
        $service = new DentalService();
        $appointment = $service->schedule(
            patient: $patient,
            date: $date,
            type: $type
        );

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'date' => $date,
            'type' => $type
        ]);
    }
}
```

## Feature Testing

### Controllers
```php
class PatientControllerTest extends TestCase
{
    /** @test */
    public function it_stores_patient_data()
    {
        $response = $this->postJson('/api/patients', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'id',
                    'name',
                    'email'
                ]);
    }
}
```

### Forms
```php
class PatientFormTest extends TestCase
{
    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post('/patients', []);

        $response->assertSessionHasErrors(['name', 'email']);
    }
}
```

## Integration Testing

### API
```php
class PatientApiTest extends TestCase
{
    /** @test */
    public function it_handles_patient_workflow()
    {
        // Create patient
        $patient = $this->postJson('/api/patients', [
            'name' => 'John Doe'
        ]);

        // Schedule appointment
        $appointment = $this->postJson("/api/patients/{$patient->id}/appointments", [
            'date' => now()->addDay()
        ]);

        // Verify workflow
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $patient->id,
            'date' => now()->addDay()
        ]);
    }
}
```

### Events
```php
class PatientEventsTest extends TestCase
{
    /** @test */
    public function it_emits_events()
    {
        Event::fake();

        $patient = Patient::factory()->create();
        $patient->update(['status' => 'active']);

        Event::assertDispatched(PatientStatusChanged::class);
    }
}
```

## Browser Testing

### Laravel Dusk
```php
class PatientWorkflowTest extends DuskTestCase
{
    /** @test */
    public function it_completes_patient_registration()
    {
        $this->browse(function ($browser) {
            $browser->visit('/patients/create')
                   ->type('name', 'John Doe')
                   ->type('email', 'john@example.com')
                   ->press('Register')
                   ->assertSee('Patient registered successfully');
        });
    }
}
```

### Visual Testing
```php
class PatientPageTest extends DuskTestCase
{
    /** @test */
    public function it_renders_patient_page_correctly()
    {
        $this->browse(function ($browser) {
            $browser->visit('/patients/1')
                   ->assertSee('Patient Details')
                   ->assertSee('Appointments')
                   ->assertSee('Documents');
        });
    }
}
```

## Performance Testing

### Load Testing
```php
class PatientApiPerformanceTest extends TestCase
{
    /** @test */
    public function it_handles_concurrent_requests()
    {
        $response = Http::pool(fn ($pool) => [
            $pool->get('/api/patients'),
            $pool->get('/api/patients'),
            $pool->get('/api/patients'),
        ]);

        $this->assertTrue($response->successful());
    }
}
```

### Query Testing
```php
class PatientQueryTest extends TestCase
{
    /** @test */
    public function it_optimizes_queries()
    {
        DB::enableQueryLog();

        $patients = Patient::with(['appointments', 'documents'])->get();

        $this->assertCount(2, DB::getQueryLog());
    }
}
```

## CI/CD

### GitHub Actions
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
      - name: Install Dependencies
        run: composer install
      - name: Execute Tests
        run: php artisan test
```

### Test Environment
```env
TESTING_DATABASE_URL=mysql://user:password@localhost/saluteora_testing
TESTING_REDIS_URL=redis://localhost:6379/1
TESTING_QUEUE_CONNECTION=sync
``` 