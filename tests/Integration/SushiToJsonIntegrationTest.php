<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test di integrazione per il trait SushiToJson.
 * 
 * Testa l'integrazione del trait con il sistema multi-tenant,
 * verificando l'isolamento dei dati e la gestione dei percorsi.
 */
class SushiToJsonIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant1;
    private Tenant $tenant2;
    private string $tenant1Path;
    private string $tenant2Path;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crea tenant di test
        $this->tenant1 = Tenant::factory()->create([
            'name' => 'Test Tenant 1',
            'domain' => 'tenant1.test',
        ]);
        
        $this->tenant2 = Tenant::factory()->create([
            'name' => 'Test Tenant 2',
            'domain' => 'tenant2.test',
        ]);
        
        // Configura percorsi per i tenant
        $this->tenant1Path = config_path($this->tenant1->name . '/database/content');
        $this->tenant2Path = config_path($this->tenant2->name . '/database/content');
        
        // Crea directory per i tenant
        if (!File::exists($this->tenant1Path)) {
            File::makeDirectory($this->tenant1Path, 0755, true, true);
        }
        if (!File::exists($this->tenant2Path)) {
            File::makeDirectory($this->tenant2Path, 0755, true, true);
        }
    }

    protected function tearDown(): void
    {
        // Cleanup directory tenant
        if (File::exists($this->tenant1Path)) {
            File::deleteDirectory(dirname($this->tenant1Path));
        }
        if (File::exists($this->tenant2Path)) {
            File::deleteDirectory(dirname($this->tenant2Path));
        }
        
        parent::tearDown();
    }

    /**
     * Test per l'isolamento dei dati tra tenant diversi.
     */
    public function test_tenant_data_isolation(): void
    {
        // Configura tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model1 = new TestSushiModel();
        $data1 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 1 Item',
                'description' => 'Item specifico per tenant 1',
                'status' => 'active',
            ],
        ];
        
        $model1->saveToJson($data1);
        
        // Verifica che i dati siano salvati nel percorso corretto del tenant 1
        $this->assertFileExists($this->tenant1Path . '/test_sushi.json');
        $this->assertFileDoesNotExist($this->tenant2Path . '/test_sushi.json');
        
        // Configura tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);
        
        $model2 = new TestSushiModel();
        $data2 = [
            '1' => [
                'id' => 1,
                'name' => 'Tenant 2 Item',
                'description' => 'Item specifico per tenant 2',
                'status' => 'inactive',
            ],
        ];
        
        $model2->saveToJson($data2);
        
        // Verifica che i dati siano salvati nel percorso corretto del tenant 2
        $this->assertFileExists($this->tenant2Path . '/test_sushi.json');
        
        // Verifica che i dati dei tenant siano diversi
        $tenant1Data = json_decode(File::get($this->tenant1Path . '/test_sushi.json'), true);
        $tenant2Data = json_decode(File::get($this->tenant2Path . '/test_sushi.json'), true);
        
        $this->assertEquals('Tenant 1 Item', $tenant1Data['1']['name']);
        $this->assertEquals('Tenant 2 Item', $tenant2Data['1']['name']);
        $this->assertNotEquals($tenant1Data, $tenant2Data);
    }

    /**
     * Test per la gestione dei percorsi file specifici per tenant.
     */
    public function test_tenant_specific_file_paths(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model = new TestSushiModel();
        $path = $model->getJsonFile();
        
        // Verifica che il percorso contenga il nome del tenant
        $this->assertStringContainsString($this->tenant1->name, $path);
        $this->assertStringContainsString('database/content', $path);
        $this->assertStringContainsString('test_sushi.json', $path);
    }

    /**
     * Test per la persistenza dei dati durante switch tenant.
     */
    public function test_data_persistence_during_tenant_switch(): void
    {
        // Crea dati per tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model1 = new TestSushiModel();
        $data1 = [
            '1' => ['id' => 1, 'name' => 'Tenant 1 Data'],
            '2' => ['id' => 2, 'name' => 'More Tenant 1 Data'],
        ];
        
        $model1->saveToJson($data1);
        
        // Verifica che i dati siano salvati
        $this->assertFileExists($this->tenant1Path . '/test_sushi.json');
        
        // Switch a tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);
        
        $model2 = new TestSushiModel();
        $data2 = [
            '1' => ['id' => 1, 'name' => 'Tenant 2 Data'],
        ];
        
        $model2->saveToJson($data2);
        
        // Verifica che i dati del tenant 1 siano ancora presenti
        $this->assertFileExists($this->tenant1Path . '/test_sushi.json');
        $this->assertFileExists($this->tenant2Path . '/test_sushi.json');
        
        // Verifica che i dati siano diversi
        $tenant1Data = json_decode(File::get($this->tenant1Path . '/test_sushi.json'), true);
        $tenant2Data = json_decode(File::get($this->tenant2Path . '/test_sushi.json'), true);
        
        $this->assertNotEquals($tenant1Data, $tenant2Data);
    }

    /**
     * Test per la gestione degli eventi Eloquent in contesto multi-tenant.
     */
    public function test_eloquent_events_in_multi_tenant_context(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model = new TestSushiModel();
        $model->name = 'Test Item';
        $model->description = 'Test Description';
        
        // Simula evento creating
        $model->fireModelEvent('creating');
        
        // Verifica che i dati siano stati salvati nel file JSON del tenant corretto
        $this->assertFileExists($this->tenant1Path . '/test_sushi.json');
        
        $savedData = json_decode(File::get($this->tenant1Path . '/test_sushi.json'), true);
        $this->assertArrayHasKey($model->id, $savedData);
        $this->assertEquals('Test Item', $savedData[$model->id]['name']);
    }

    /**
     * Test per la gestione degli errori in contesto multi-tenant.
     */
    public function test_error_handling_in_multi_tenant_context(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        // Test con directory non scrivibile
        $nonWritablePath = '/non/writable/path';
        
        // Mock TenantService per restituire percorso non scrivibile
        $this->mock(TenantService::class, function ($mock) use ($nonWritablePath) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($nonWritablePath . '/test_sushi.json');
        });
        
        $model = new TestSushiModel();
        $testData = ['test' => 'data'];
        
        $result = $model->saveToJson($testData);
        
        $this->assertFalse($result);
    }

    /**
     * Test per la gestione di file JSON condivisi tra tenant.
     */
    public function test_shared_json_files_between_tenants(): void
    {
        // Crea un file JSON condiviso
        $sharedData = [
            '1' => ['id' => 1, 'name' => 'Shared Item', 'type' => 'common'],
            '2' => ['id' => 2, 'name' => 'Another Shared Item', 'type' => 'common'],
        ];
        
        $sharedPath = config_path('shared/database/content');
        if (!File::exists($sharedPath)) {
            File::makeDirectory($sharedPath, 0755, true, true);
        }
        
        File::put($sharedPath . '/test_sushi.json', json_encode($sharedData, JSON_PRETTY_PRINT));
        
        // Mock TenantService per restituire percorso condiviso
        $this->mock(TenantService::class, function ($mock) use ($sharedPath) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($sharedPath . '/test_sushi.json');
        });
        
        // Test con tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model1 = new TestSushiModel();
        $rows1 = $model1->getSushiRows();
        
        // Test con tenant 2
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);
        
        $model2 = new TestSushiModel();
        $rows2 = $model2->getSushiRows();
        
        // Verifica che entrambi i tenant vedano gli stessi dati condivisi
        $this->assertEquals($rows1, $rows2);
        $this->assertEquals('Shared Item', $rows1['1']['name']);
        
        // Cleanup
        File::deleteDirectory(dirname($sharedPath));
    }

    /**
     * Test per la gestione di operazioni CRUD multiple in contesto multi-tenant.
     */
    public function test_crud_operations_in_multi_tenant_context(): void
    {
        // Test con tenant 1
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model1 = new TestSushiModel();
        
        // Create
        $data1 = [
            '1' => ['id' => 1, 'name' => 'Tenant 1 Item 1'],
            '2' => ['id' => 2, 'name' => 'Tenant 1 Item 2'],
        ];
        $model1->saveToJson($data1);
        
        // Read
        $rows1 = $model1->getSushiRows();
        $this->assertCount(2, $rows1);
        
        // Update
        $data1['1']['name'] = 'Updated Tenant 1 Item 1';
        $model1->saveToJson($data1);
        
        $updatedRows1 = $model1->getSushiRows();
        $this->assertEquals('Updated Tenant 1 Item 1', $updatedRows1['1']['name']);
        
        // Delete (simula rimozione di un record)
        unset($data1['2']);
        $model1->saveToJson($data1);
        
        $finalRows1 = $model1->getSushiRows();
        $this->assertCount(1, $finalRows1);
        $this->assertArrayNotHasKey('2', $finalRows1);
        
        // Test con tenant 2 (dati completamente separati)
        $this->actingAs($this->createUserForTenant($this->tenant2));
        $this->setCurrentTenant($this->tenant2);
        
        $model2 = new TestSushiModel();
        $rows2 = $model2->getSushiRows();
        
        // Verifica che il tenant 2 non veda i dati del tenant 1
        $this->assertEmpty($rows2);
    }

    /**
     * Test per la gestione di file JSON con permessi diversi.
     */
    public function test_json_file_permissions_in_multi_tenant_context(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        $model = new TestSushiModel();
        $testData = ['test' => 'data'];
        
        $result = $model->saveToJson($testData);
        $this->assertTrue($result);
        
        // Verifica permessi del file creato
        $filePath = $model->getJsonFile();
        $this->assertFileExists($filePath);
        
        $permissions = substr(sprintf('%o', fileperms($filePath)), -4);
        $this->assertEquals('0644', $permissions);
        
        // Verifica permessi della directory
        $directoryPath = dirname($filePath);
        $dirPermissions = substr(sprintf('%o', fileperms($directoryPath)), -4);
        $this->assertEquals('0755', $dirPermissions);
    }

    /**
     * Test per la gestione di errori di rete o file system in contesto multi-tenant.
     */
    public function test_network_filesystem_errors_in_multi_tenant_context(): void
    {
        $this->actingAs($this->createUserForTenant($this->tenant1));
        $this->setCurrentTenant($this->tenant1);
        
        // Simula errore di rete (file system non disponibile)
        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn('//unreachable/network/path/test_sushi.json');
        });
        
        $model = new TestSushiModel();
        
        // Test getSushiRows con errore di rete
        $this->expectException(\Exception::class);
        $model->getSushiRows();
    }

    /**
     * Crea un utente per un tenant specifico.
     */
    private function createUserForTenant(Tenant $tenant): \Modules\User\Models\User
    {
        $user = \Modules\User\Models\User::factory()->create();
        
        // Associa l'utente al tenant
        $user->tenants()->attach($tenant->id);
        
        return $user;
    }

    /**
     * Imposta il tenant corrente per il test.
     */
    private function setCurrentTenant(Tenant $tenant): void
    {
        // Simula il contesto del tenant corrente
        app()->instance('current_tenant', $tenant);
        
        // Mock TenantService per restituire percorsi specifici del tenant
        $this->mock(TenantService::class, function ($mock) use ($tenant) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn(config_path($tenant->name . '/database/content/test_sushi.json'));
        });
    }
}
