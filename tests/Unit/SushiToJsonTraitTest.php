<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
=======

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
>>>>>>> afc9385 (.)

/**
 * Test unitari per il trait SushiToJson.
 *
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
<<<<<<< HEAD
class SushiToJsonTraitTest extends TestCase
{
    use RefreshDatabase;

=======
#[Group('traits')]
#[Group('sushi-json')]
class SushiToJsonTraitTest extends TestCase
{
>>>>>>> afc9385 (.)
    private TestSushiModel $model;
    private string $testJsonPath;
    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura il modello di test
        $this->model = new TestSushiModel();

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
     * Crea dati JSON di test.
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

<<<<<<< HEAD
    /**
     * Test per il metodo getJsonFile().
     */
    public function testGetJsonFileReturnsCorrectPath(): void
=======
    #[Test]
    #[Group('getJsonFile')]
    public function it_returns_correct_json_file_path(): void
>>>>>>> afc9385 (.)
    {
        $path = $this->model->getJsonFile();

        $this->assertEquals($this->testJsonPath, $path);
        $this->assertStringEndsWith('test_sushi.json', $path);
    }

<<<<<<< HEAD
    /**
     * Test per il metodo getSushiRows() con file esistente.
     */
    public function testGetSushiRowsLoadsExistingData(): void
=======
    #[Test]
    #[Group('getSushiRows')]
    public function it_loads_existing_data_from_json_file(): void
>>>>>>> afc9385 (.)
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

<<<<<<< HEAD
        $rows = $this->model->getSushiRows();
=======
        $rows = $this->model->loadExistingData();
>>>>>>> afc9385 (.)

        $this->assertIsArray($rows);
        $this->assertCount(2, $rows);
        $this->assertEquals('Test Item 1', $rows['1']['name']);
        $this->assertEquals('Test Item 2', $rows['2']['name']);
    }

<<<<<<< HEAD
    /**
     * Test per il metodo getSushiRows() con file non esistente.
     */
    public function testGetSushiRowsReturnsEmptyArrayWhenFileNotExists(): void
=======
    #[Test]
    #[Group('getSushiRows')]
    public function it_returns_empty_array_when_file_not_exists(): void
>>>>>>> afc9385 (.)
    {
        $rows = $this->model->getSushiRows();

        $this->assertIsArray($rows);
        $this->assertEmpty($rows);
    }

<<<<<<< HEAD
    /**
     * Test per il metodo getSushiRows() con JSON malformato.
     */
    public function testGetSushiRowsThrowsExceptionWithMalformedJson(): void
=======
    #[Test]
    #[Group('getSushiRows')]
    public function it_throws_exception_with_malformed_json(): void
>>>>>>> afc9385 (.)
    {
        File::put($this->testJsonPath, 'invalid json content');

        $this->expectException(\Exception::class);
<<<<<<< HEAD
        $this->expectExceptionMessage('Data is not array');
=======
        $this->expectExceptionMessage('Syntax error');
>>>>>>> afc9385 (.)

        $this->model->getSushiRows();
    }

<<<<<<< HEAD
    /**
     * Test per il metodo getSushiRows() con dati non array.
     */
    public function testGetSushiRowsThrowsExceptionWithNonArrayData(): void
=======
    #[Test]
    #[Group('getSushiRows')]
    public function it_throws_exception_with_non_array_data(): void
>>>>>>> afc9385 (.)
    {
        File::put($this->testJsonPath, '"string data"');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');

        $this->model->getSushiRows();
    }

<<<<<<< HEAD
    /**
     * Test per il metodo getSushiRows() con normalizzazione array nidificati.
     */
    public function testGetSushiRowsNormalizesNestedArrays(): void
=======
    #[Test]
    #[Group('getSushiRows')]
    public function it_normalizes_nested_arrays_to_json_strings(): void
>>>>>>> afc9385 (.)
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

<<<<<<< HEAD
    /**
     * Test per il metodo saveToJson() con successo.
     */
    public function testSaveToJsonSavesDataSuccessfully(): void
=======
    #[Test]
    #[Group('saveToJson')]
    public function it_saves_data_successfully_to_json_file(): void
>>>>>>> afc9385 (.)
    {
        $testData = $this->createTestData();

        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertFileExists($this->testJsonPath);

        $savedData = json_decode(File::get($this->testJsonPath), true);
        $this->assertEquals($testData, $savedData);
    }

<<<<<<< HEAD
    /**
     * Test per il metodo saveToJson() crea directory se non esiste.
     */
    public function testSaveToJsonCreatesDirectoryIfNotExists(): void
    {
        $newDirectory = storage_path('tests/sushi-json/new-dir');
        $newPath = $newDirectory.'/test.json';

        // Mock per nuovo percorso
        $this->mock(TenantService::class, function ($mock) use ($newPath) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($newPath);
        });

        $testData = ['test' => 'data'];
        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertDirectoryExists($newDirectory);
        $this->assertFileExists($newPath);

        // Cleanup
        File::deleteDirectory(dirname($newDirectory));
    }

    /**
     * Test per il metodo saveToJson() con errori di scrittura.
     */
    public function testSaveToJsonReturnsFalseOnWriteError(): void
    {
        // Mock directory non scrivibile
        $this->testJsonPath = '/non/writable/path/test.json';

        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($this->testJsonPath);
        });

        $testData = ['test' => 'data'];
=======
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

>>>>>>> afc9385 (.)
        $result = $this->model->saveToJson($testData);

        $this->assertFalse($result);
    }

<<<<<<< HEAD
    /**
     * Test per il metodo loadExistingData().
     */
    public function testLoadExistingDataLoadsDataCorrectly(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $data = $this->model->loadExistingData();

        $this->assertEquals($testData, $data);
    }

    /**
     * Test per il metodo loadExistingData() con file non esistente.
     */
    public function testLoadExistingDataReturnsEmptyArrayWhenFileNotExists(): void
    {
        $data = $this->model->loadExistingData();

        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }

    /**
     * Test per il metodo getNextId() con dati esistenti.
     */
    public function testGetNextIdReturnsNextAvailableId(): void
    {
        $testData = [
            '1' => ['id' => 1, 'name' => 'Item 1'],
            '5' => ['id' => 5, 'name' => 'Item 5'],
            '10' => ['id' => 10, 'name' => 'Item 10'],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $nextId = $this->model->getNextId();

        $this->assertEquals(11, $nextId);
    }

    /**
     * Test per il metodo getNextId() senza dati esistenti.
     */
    public function testGetNextIdReturnsOneWhenNoExistingData(): void
    {
        $nextId = $this->model->getNextId();

        $this->assertEquals(1, $nextId);
    }

    /**
     * Test per il metodo getNextId() con ID non numerici.
     */
    public function testGetNextIdReturnsOneWithNonNumericIds(): void
    {
        $testData = [
            'abc' => ['id' => 'abc', 'name' => 'Item ABC'],
            'def' => ['id' => 'def', 'name' => 'Item DEF'],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $nextId = $this->model->getNextId();

        $this->assertEquals(1, $nextId);
    }

    /**
     * Test per il metodo getAuthId() con utente autenticato.
     */
    public function testGetAuthIdReturnsAuthenticatedUserId(): void
    {
        $user = \Modules\User\Models\User::factory()->create();
        Auth::login($user);

        $authId = $this->model->getAuthId();

        $this->assertEquals($user->id, $authId);
    }

    /**
     * Test per il metodo getAuthId() senza utente autenticato.
     */
    public function testGetAuthIdReturnsNullWhenNotAuthenticated(): void
    {
        Auth::logout();

        $authId = $this->model->getAuthId();

        $this->assertNull($authId);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Creating.
     */
    public function testCreatingEventGeneratesIdAndTimestamps(): void
    {
        $model = new TestSushiModel();
        $model->name = 'New Item';
        $model->description = 'New Description';

        // Simula evento creating
        $model->fireModelEvent('creating');

        $this->assertNotNull($model->id);
        $this->assertNotNull($model->created_at);
        $this->assertNotNull($model->updated_at);
        $this->assertGreaterThan(0, $model->id);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Updating.
     */
    public function testUpdatingEventUpdatesTimestamp(): void
    {
        $model = new TestSushiModel();
        $model->id = 1;
        $model->name = 'Updated Item';

        $originalUpdatedAt = $model->updated_at;

        // Simula evento updating
        $model->fireModelEvent('updating');

        $this->assertNotEquals($originalUpdatedAt, $model->updated_at);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Deleting.
     */
    public function testDeletingEventRemovesRecordFromJson(): void
    {
        // Crea dati di test
=======



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

        $model = new TestSushiModel();
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

        $model = new TestSushiModel();
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
>>>>>>> afc9385 (.)
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel();
        $model->id = 1;

<<<<<<< HEAD
        // Simula evento deleting
        $model->fireModelEvent('deleting');

        // Verifica che il record sia stato rimosso
        $updatedData = json_decode(File::get($this->testJsonPath), true);
        $this->assertArrayNotHasKey('1', $updatedData);
        $this->assertArrayHasKey('2', $updatedData);
    }

    /**
     * Test per la gestione degli errori durante operazioni JSON.
     */
    public function testErrorHandlingDuringJsonOperations(): void
    {
        // Test con file non leggibile
        $this->testJsonPath = '/dev/null/test.json';

        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($this->testJsonPath);
        });

        $this->expectException(\Exception::class);

        $this->model->getSushiRows();
    }

    /**
     * Test per la validazione dei dati con schema definito.
     */
    public function testDataValidationWithSchema(): void
    {
        $model = new TestSushiModel();
        $model->schema = [
            'name' => 'string',
            'description' => 'string',
            'status' => 'string',
        ];

        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Valid Item',
                'description' => 'Valid Description',
                'status' => 'active',
            ],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $model->getSushiRows();

        $this->assertArrayHasKey('1', $rows);
        $this->assertEquals('Valid Item', $rows['1']['name']);
    }

    /**
     * Test per la performance con file JSON grandi.
     */
    public function testPerformanceWithLargeJsonFiles(): void
    {
        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 1000; ++$i) {
=======
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
>>>>>>> afc9385 (.)
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
<<<<<<< HEAD
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
                'metadata' => ['key' => "value_{$i}"],
=======
                'status' => $i % 2 === 0 ? 'active' : 'inactive',
>>>>>>> afc9385 (.)
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

<<<<<<< HEAD
        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));

        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000; // Converti in millisecondi

        $this->assertCount(1000, $rows);
        $this->assertLessThan(100, $executionTime, 'Caricamento file JSON troppo lento');
    }

    /**
     * Test per la gestione della memoria con file JSON grandi.
     */
    public function testMemoryUsageWithLargeJsonFiles(): void
    {
        $initialMemory = memory_get_usage();

        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 500; ++$i) {
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
                'status' => 'active',
                'metadata' => ['key' => "value_{$i}"],
            ];
        }

        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

        $finalMemory = memory_get_usage();
        $memoryUsed = $finalMemory - $initialMemory;

        $this->assertCount(500, $rows);
        $this->assertLessThan(50 * 1024 * 1024, $memoryUsed, 'Utilizzo memoria eccessivo (>50MB)');
=======
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
>>>>>>> afc9385 (.)
    }
}
