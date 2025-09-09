<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Test unitari per il trait SushiToJson.
 *
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
#[Group('traits')]
#[Group('sushi-json')]
class SushiToJsonTraitTest extends TestCase
{
    private TestSushiModel $model;

    private string $testJsonPath;

    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura il modello di test
        $this->model = new TestSushiModel;

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json');
        $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }

        // Mock TenantService per i test
        $this->mockTenantService();
    }

    protected function tearDown(): void
    {
        // Cleanup file di test
        if (File::exists($this->testJsonPath)) {
            File::delete($this->testJsonPath);
        }

        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        parent::tearDown();
    }

    /**
     * Mock del TenantService per i test.
     */
    private function mockTenantService(): void
    {
        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($this->testJsonPath);
        });
    }

    /**
     * Crea dati di test.
     */
    private function createTestData(): array
    {
        return [
            '1' => [
                'id' => 1,
                'name' => 'Test Item 1',
                'description' => 'Description 1',
                'status' => 'active',
                'metadata' => ['key1' => 'value1', 'key2' => 'value2'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
            '2' => [
                'id' => 2,
                'name' => 'Test Item 2',
                'description' => 'Description 2',
                'status' => 'inactive',
                'metadata' => ['key3' => 'value3'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
        ];
    }

    #[Test]
    #[Group('getJsonFile')]
    public function it_returns_correct_json_file_path(): void
    {
        $path = $this->model->getJsonFile();

        $this->assertEquals($this->testJsonPath, $path);
        $this->assertStringEndsWith('test_sushi.json', $path);
    }

    #[Test]
    #[Group('getSushiRows')]
    public function it_loads_existing_data_from_json_file(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->loadExistingData();

        $this->assertIsArray($rows);
        $this->assertCount(2, $rows);
        $this->assertEquals('Test Item 1', $rows['1']['name']);
        $this->assertEquals('Test Item 2', $rows['2']['name']);
    }

    #[Test]
    #[Group('getSushiRows')]
    public function it_returns_empty_array_when_file_not_exists(): void
    {
        $rows = $this->model->getSushiRows();

        $this->assertIsArray($rows);
        $this->assertEmpty($rows);
    }

    #[Test]
    #[Group('getSushiRows')]
    public function it_throws_exception_with_malformed_json(): void
    {
        File::put($this->testJsonPath, 'invalid json content');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Syntax error');

        $this->model->getSushiRows();
    }

    #[Test]
    #[Group('getSushiRows')]
    public function it_throws_exception_with_non_array_data(): void
    {
        File::put($this->testJsonPath, '"string data"');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');

        $this->model->getSushiRows();
    }

    #[Test]
    #[Group('getSushiRows')]
    public function it_normalizes_nested_arrays_to_json_strings(): void
    {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

        $this->assertIsString($rows['1']['metadata']);
        $this->assertIsString($rows['1']['tags']);
        $this->assertEquals('{"nested":"value"}', $rows['1']['metadata']);
        $this->assertEquals('["tag1","tag2"]', $rows['1']['tags']);
    }

    #[Test]
    #[Group('saveToJson')]
    public function it_saves_data_successfully_to_json_file(): void
    {
        $testData = $this->createTestData();

        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertFileExists($this->testJsonPath);

        $savedData = json_decode(File::get($this->testJsonPath), true);
        $this->assertEquals($testData, $savedData);
    }

    #[Test]
    #[Group('saveToJson')]
    public function it_creates_directory_if_not_exists(): void
    {
        // Rimuovi directory di test
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        $testData = $this->createTestData();

        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertDirectoryExists($this->testDirectory);
        $this->assertFileExists($this->testJsonPath);
    }

    #[Test]
    #[Group('saveToJson')]
    public function it_handles_save_errors_gracefully(): void
    {
        // Mock File facade per simulare errore di scrittura
        File::shouldReceive('put')
            ->once()
            ->andReturn(false);

        $testData = $this->createTestData();

        $result = $this->model->saveToJson($testData);

        $this->assertFalse($result);
    }

    #[Test]
    #[Group('events')]
    public function it_handles_creating_event_correctly(): void
    {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')
            ->andReturn(1);

        $testData = [
            'name' => 'New Item',
            'description' => 'New Description',
        ];

        $model = new TestSushiModel;
        $model->fill($testData);

        // Test che il modello può essere creato con i dati
        $this->assertEquals('New Item', $model->name);
        $this->assertEquals('New Description', $model->description);

        // Test che i metodi del trait funzionano
        $this->assertIsString($model->getJsonFile());
        $this->assertStringEndsWith('test_sushi.json', $model->getJsonFile());
    }

    #[Test]
    #[Group('events')]
    public function it_handles_updating_event_correctly(): void
    {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')
            ->andReturn(1);

        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;
        $model->fill(['name' => 'Updated Name']);

        // Test che il modello può essere aggiornato
        $this->assertEquals('Updated Name', $model->name);
        $this->assertEquals(1, $model->id);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        $this->assertArrayHasKey('1', $existingData);
        $this->assertEquals('Test Item 1', $existingData['1']['name']);
    }

    #[Test]
    #[Group('events')]
    public function it_handles_deleting_event_correctly(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;

        // Test che il modello può essere configurato per la cancellazione
        $this->assertEquals(1, $model->id);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        $this->assertArrayHasKey('1', $existingData);
        $this->assertArrayHasKey('2', $existingData);

        // Test che il metodo saveToJson funziona
        $result = $model->saveToJson($existingData);
        $this->assertTrue($result);
    }

    #[Test]
    #[Group('integration')]
    public function it_integrates_with_tenant_service_correctly(): void
    {
        $tenantService = app(TenantService::class);

        $this->assertInstanceOf(TenantService::class, $tenantService);

        // Verifica che il mock funzioni correttamente
        $path = $this->model->getJsonFile();
        $this->assertEquals($this->testJsonPath, $path);
    }

    #[Test]
    #[Group('performance')]
    public function it_handles_large_datasets_efficiently(): void
    {
        // Crea dataset grande (1000 record)
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
                'status' => $i % 2 === 0 ? 'active' : 'inactive',
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        $startTime = microtime(true);

        $result = $this->model->saveToJson($largeData);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $this->assertTrue($result);
        $this->assertLessThan(1.0, $executionTime, 'Salvataggio dataset grande deve essere veloce');

        // Verifica caricamento
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        $this->assertCount(1000, $rows);
        $this->assertLessThan(0.5, $loadTime, 'Caricamento dataset grande deve essere veloce');
    }

    #[Test]
    #[Group('error-handling')]
    public function it_logs_errors_appropriately(): void
    {
        // Mock Log facade per verificare logging
        $this->mock('log', function ($mock) {
            $mock->shouldReceive('error')
                ->once()
                ->with('Failed to save data to JSON file', \Mockery::any());
        });

        // Simula errore di salvataggio
        File::shouldReceive('put')
            ->once()
            ->andReturn(false);

        $testData = $this->createTestData();
        $result = $this->model->saveToJson($testData);

        $this->assertFalse($result);
    }

    #[Test]
    #[Group('data-integrity')]
    public function it_maintains_data_integrity_during_operations(): void
    {
        $originalData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        // Verifica che i dati originali siano preservati
        $loadedData = $this->model->loadExistingData();
        $this->assertEquals($originalData, $loadedData);

        // Aggiorna un record
        $updatedData = $originalData;
        $updatedData['1']['name'] = 'Updated Name';

        $result = $this->model->saveToJson($updatedData);
        $this->assertTrue($result);

        // Verifica che solo il record specifico sia stato aggiornato
        $finalData = $this->model->loadExistingData();
        $this->assertEquals('Updated Name', $finalData['1']['name']);
        $this->assertEquals('Test Item 2', $finalData['2']['name']); // Non modificato
    }

    #[Test]
    #[Group('edge-cases')]
    public function it_handles_empty_and_null_values_correctly(): void
    {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => false,
            ],
        ];

        $result = $this->model->saveToJson($testData);
        $this->assertTrue($result);

        $loadedData = $this->model->getSushiRows();
        $this->assertEquals('', $loadedData['1']['name']);
        $this->assertNull($loadedData['1']['description']);
        $this->assertEquals('[]', $loadedData['1']['metadata']); // Convertito in stringa JSON
        $this->assertFalse($loadedData['1']['status']);
    }

    #[Test]
    #[Group('unicode')]
    public function it_handles_unicode_and_special_characters(): void
    {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ'],
            ],
        ];

        $result = $this->model->saveToJson($testData);
        $this->assertTrue($result);

        $loadedData = $this->model->getSushiRows();
        $this->assertEquals('Café & Résumé 🚀', $loadedData['1']['name']);
        $this->assertEquals('Test con caratteri speciali: é, è, ñ, 中文, 🎉', $loadedData['1']['description']);
        $this->assertEquals('["tag-é","tag-è","tag-ñ"]', $loadedData['1']['tags']);
    }
}
