<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5ea82dc (.)
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test unitari per il trait SushiToJson.
<<<<<<< HEAD
 *
=======
 * 
=======
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Tests\TestCase;

/**
 * Test unitari per il trait SushiToJson.
 *
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
class SushiToJsonTraitTest extends TestCase
{
    use RefreshDatabase;

    private TestSushiModel $model;
    private string $testJsonPath;
    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        // Configura il modello di test
        $this->model = new TestSushiModel();
        
        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json');
        $this->testJsonPath = $this->testDirectory . '/test_sushi.json';
        
        // Crea directory di test
        if (!File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }
        
=======
>>>>>>> 5ea82dc (.)

        // Configura il modello di test
        $this->model = new TestSushiModel();

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json');
        $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        // Mock TenantService per i test
        $this->mockTenantService();
    }

    protected function tearDown(): void
    {
        // Cleanup file di test
        if (File::exists($this->testJsonPath)) {
            File::delete($this->testJsonPath);
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }
        
=======
>>>>>>> 5ea82dc (.)

        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
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

    /**
     * Test per il metodo getJsonFile().
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_json_file_returns_correct_path(): void
    {
        $path = $this->model->getJsonFile();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetJsonFileReturnsCorrectPath(): void
    {
        $path = $this->model->getJsonFile();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals($this->testJsonPath, $path);
        $this->assertStringEndsWith('test_sushi.json', $path);
    }

    /**
     * Test per il metodo getSushiRows() con file esistente.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_sushi_rows_loads_existing_data(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $rows = $this->model->getSushiRows();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetSushiRowsLoadsExistingData(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertIsArray($rows);
        $this->assertCount(2, $rows);
        $this->assertEquals('Test Item 1', $rows['1']['name']);
        $this->assertEquals('Test Item 2', $rows['2']['name']);
    }

    /**
     * Test per il metodo getSushiRows() con file non esistente.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_sushi_rows_returns_empty_array_when_file_not_exists(): void
    {
        $rows = $this->model->getSushiRows();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetSushiRowsReturnsEmptyArrayWhenFileNotExists(): void
    {
        $rows = $this->model->getSushiRows();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertIsArray($rows);
        $this->assertEmpty($rows);
    }

    /**
     * Test per il metodo getSushiRows() con JSON malformato.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_sushi_rows_throws_exception_with_malformed_json(): void
    {
        File::put($this->testJsonPath, 'invalid json content');
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetSushiRowsThrowsExceptionWithMalformedJson(): void
    {
        File::put($this->testJsonPath, 'invalid json content');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->model->getSushiRows();
    }

    /**
     * Test per il metodo getSushiRows() con dati non array.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_sushi_rows_throws_exception_with_non_array_data(): void
    {
        File::put($this->testJsonPath, '"string data"');
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetSushiRowsThrowsExceptionWithNonArrayData(): void
    {
        File::put($this->testJsonPath, '"string data"');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Data is not array');

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->model->getSushiRows();
    }

    /**
     * Test per il metodo getSushiRows() con normalizzazione array nidificati.
     */
<<<<<<< HEAD
    public function testGetSushiRowsNormalizesNestedArrays(): void
=======
<<<<<<< HEAD
    public function test_get_sushi_rows_normalizes_nested_arrays(): void
=======
    public function testGetSushiRowsNormalizesNestedArrays(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $rows = $this->model->getSushiRows();
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertIsString($rows['1']['metadata']);
        $this->assertIsString($rows['1']['tags']);
        $this->assertEquals('{"nested":"value"}', $rows['1']['metadata']);
        $this->assertEquals('["tag1","tag2"]', $rows['1']['tags']);
    }

    /**
     * Test per il metodo saveToJson() con successo.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_save_to_json_saves_data_successfully(): void
    {
        $testData = $this->createTestData();
        
        $result = $this->model->saveToJson($testData);
        
        $this->assertTrue($result);
        $this->assertFileExists($this->testJsonPath);
        
=======
>>>>>>> 5ea82dc (.)
    public function testSaveToJsonSavesDataSuccessfully(): void
    {
        $testData = $this->createTestData();

        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertFileExists($this->testJsonPath);

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $savedData = json_decode(File::get($this->testJsonPath), true);
        $this->assertEquals($testData, $savedData);
    }

    /**
     * Test per il metodo saveToJson() crea directory se non esiste.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_save_to_json_creates_directory_if_not_exists(): void
    {
        $newDirectory = storage_path('tests/sushi-json/new-dir');
        $newPath = $newDirectory . '/test.json';
        
=======
>>>>>>> 5ea82dc (.)
    public function testSaveToJsonCreatesDirectoryIfNotExists(): void
    {
        $newDirectory = storage_path('tests/sushi-json/new-dir');
        $newPath = $newDirectory.'/test.json';

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        // Mock per nuovo percorso
        $this->mock(TenantService::class, function ($mock) use ($newPath) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($newPath);
        });
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        $testData = ['test' => 'data'];
        $result = $this->model->saveToJson($testData);
        
        $this->assertTrue($result);
        $this->assertDirectoryExists($newDirectory);
        $this->assertFileExists($newPath);
        
=======
>>>>>>> 5ea82dc (.)

        $testData = ['test' => 'data'];
        $result = $this->model->saveToJson($testData);

        $this->assertTrue($result);
        $this->assertDirectoryExists($newDirectory);
        $this->assertFileExists($newPath);

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        // Cleanup
        File::deleteDirectory(dirname($newDirectory));
    }

    /**
     * Test per il metodo saveToJson() con errori di scrittura.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_save_to_json_returns_false_on_write_error(): void
    {
        // Mock directory non scrivibile
        $this->testJsonPath = '/non/writable/path/test.json';
        
=======
>>>>>>> 5ea82dc (.)
    public function testSaveToJsonReturnsFalseOnWriteError(): void
    {
        // Mock directory non scrivibile
        $this->testJsonPath = '/non/writable/path/test.json';

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($this->testJsonPath);
        });
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        $testData = ['test' => 'data'];
        $result = $this->model->saveToJson($testData);
        
=======
>>>>>>> 5ea82dc (.)

        $testData = ['test' => 'data'];
        $result = $this->model->saveToJson($testData);

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertFalse($result);
    }

    /**
     * Test per il metodo loadExistingData().
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_load_existing_data_loads_data_correctly(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $data = $this->model->loadExistingData();
        
=======
>>>>>>> 5ea82dc (.)
    public function testLoadExistingDataLoadsDataCorrectly(): void
    {
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $data = $this->model->loadExistingData();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals($testData, $data);
    }

    /**
     * Test per il metodo loadExistingData() con file non esistente.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_load_existing_data_returns_empty_array_when_file_not_exists(): void
    {
        $data = $this->model->loadExistingData();
        
=======
>>>>>>> 5ea82dc (.)
    public function testLoadExistingDataReturnsEmptyArrayWhenFileNotExists(): void
    {
        $data = $this->model->loadExistingData();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertIsArray($data);
        $this->assertEmpty($data);
    }

    /**
     * Test per il metodo getNextId() con dati esistenti.
     */
<<<<<<< HEAD
    public function testGetNextIdReturnsNextAvailableId(): void
=======
<<<<<<< HEAD
    public function test_get_next_id_returns_next_available_id(): void
=======
    public function testGetNextIdReturnsNextAvailableId(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $testData = [
            '1' => ['id' => 1, 'name' => 'Item 1'],
            '5' => ['id' => 5, 'name' => 'Item 5'],
            '10' => ['id' => 10, 'name' => 'Item 10'],
        ];
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $nextId = $this->model->getNextId();
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $nextId = $this->model->getNextId();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals(11, $nextId);
    }

    /**
     * Test per il metodo getNextId() senza dati esistenti.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_next_id_returns_one_when_no_existing_data(): void
    {
        $nextId = $this->model->getNextId();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetNextIdReturnsOneWhenNoExistingData(): void
    {
        $nextId = $this->model->getNextId();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals(1, $nextId);
    }

    /**
     * Test per il metodo getNextId() con ID non numerici.
     */
<<<<<<< HEAD
    public function testGetNextIdReturnsOneWithNonNumericIds(): void
=======
<<<<<<< HEAD
    public function test_get_next_id_returns_one_with_non_numeric_ids(): void
=======
    public function testGetNextIdReturnsOneWithNonNumericIds(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $testData = [
            'abc' => ['id' => 'abc', 'name' => 'Item ABC'],
            'def' => ['id' => 'def', 'name' => 'Item DEF'],
        ];
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $nextId = $this->model->getNextId();
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $nextId = $this->model->getNextId();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals(1, $nextId);
    }

    /**
     * Test per il metodo getAuthId() con utente autenticato.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_auth_id_returns_authenticated_user_id(): void
    {
        $user = \Modules\User\Models\User::factory()->create();
        Auth::login($user);
        
        $authId = $this->model->getAuthId();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetAuthIdReturnsAuthenticatedUserId(): void
    {
        $user = \Modules\User\Models\User::factory()->create();
        Auth::login($user);

        $authId = $this->model->getAuthId();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertEquals($user->id, $authId);
    }

    /**
     * Test per il metodo getAuthId() senza utente autenticato.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_get_auth_id_returns_null_when_not_authenticated(): void
    {
        Auth::logout();
        
        $authId = $this->model->getAuthId();
        
=======
>>>>>>> 5ea82dc (.)
    public function testGetAuthIdReturnsNullWhenNotAuthenticated(): void
    {
        Auth::logout();

        $authId = $this->model->getAuthId();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertNull($authId);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Creating.
     */
<<<<<<< HEAD
    public function testCreatingEventGeneratesIdAndTimestamps(): void
=======
<<<<<<< HEAD
    public function test_creating_event_generates_id_and_timestamps(): void
=======
    public function testCreatingEventGeneratesIdAndTimestamps(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $model = new TestSushiModel();
        $model->name = 'New Item';
        $model->description = 'New Description';
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        // Simula evento creating
        $model->fireModelEvent('creating');
        
=======
>>>>>>> 5ea82dc (.)

        // Simula evento creating
        $model->fireModelEvent('creating');

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertNotNull($model->id);
        $this->assertNotNull($model->created_at);
        $this->assertNotNull($model->updated_at);
        $this->assertGreaterThan(0, $model->id);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Updating.
     */
<<<<<<< HEAD
    public function testUpdatingEventUpdatesTimestamp(): void
=======
<<<<<<< HEAD
    public function test_updating_event_updates_timestamp(): void
=======
    public function testUpdatingEventUpdatesTimestamp(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $model = new TestSushiModel();
        $model->id = 1;
        $model->name = 'Updated Item';
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        $originalUpdatedAt = $model->updated_at;
        
        // Simula evento updating
        $model->fireModelEvent('updating');
        
=======
>>>>>>> 5ea82dc (.)

        $originalUpdatedAt = $model->updated_at;

        // Simula evento updating
        $model->fireModelEvent('updating');

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertNotEquals($originalUpdatedAt, $model->updated_at);
    }

    /**
     * Test per la gestione degli eventi Eloquent - Deleting.
     */
<<<<<<< HEAD
    public function testDeletingEventRemovesRecordFromJson(): void
=======
<<<<<<< HEAD
    public function test_deleting_event_removes_record_from_json(): void
=======
    public function testDeletingEventRemovesRecordFromJson(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        // Crea dati di test
        $testData = $this->createTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        $model = new TestSushiModel();
        $model->id = 1;
        
        // Simula evento deleting
        $model->fireModelEvent('deleting');
        
=======
>>>>>>> 5ea82dc (.)

        $model = new TestSushiModel();
        $model->id = 1;

        // Simula evento deleting
        $model->fireModelEvent('deleting');

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        // Verifica che il record sia stato rimosso
        $updatedData = json_decode(File::get($this->testJsonPath), true);
        $this->assertArrayNotHasKey('1', $updatedData);
        $this->assertArrayHasKey('2', $updatedData);
    }

    /**
     * Test per la gestione degli errori durante operazioni JSON.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_error_handling_during_json_operations(): void
    {
        // Test con file non leggibile
        $this->testJsonPath = '/dev/null/test.json';
        
=======
>>>>>>> 5ea82dc (.)
    public function testErrorHandlingDuringJsonOperations(): void
    {
        // Test con file non leggibile
        $this->testJsonPath = '/dev/null/test.json';

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->mock(TenantService::class, function ($mock) {
            $mock->shouldReceive('filePath')
                ->with('database/content/test_sushi.json')
                ->andReturn($this->testJsonPath);
        });
<<<<<<< HEAD

        $this->expectException(\Exception::class);

=======
<<<<<<< HEAD
        
        $this->expectException(\Exception::class);
        
=======

        $this->expectException(\Exception::class);

>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->model->getSushiRows();
    }

    /**
     * Test per la validazione dei dati con schema definito.
     */
<<<<<<< HEAD
    public function testDataValidationWithSchema(): void
=======
<<<<<<< HEAD
    public function test_data_validation_with_schema(): void
=======
    public function testDataValidationWithSchema(): void
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
    {
        $model = new TestSushiModel();
        $model->schema = [
            'name' => 'string',
            'description' => 'string',
            'status' => 'string',
        ];
<<<<<<< HEAD

=======
<<<<<<< HEAD
        
=======

>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Valid Item',
                'description' => 'Valid Description',
                'status' => 'active',
            ],
        ];
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
        
        $rows = $model->getSushiRows();
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $model->getSushiRows();

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertArrayHasKey('1', $rows);
        $this->assertEquals('Valid Item', $rows['1']['name']);
    }

    /**
     * Test per la performance con file JSON grandi.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_performance_with_large_json_files(): void
    {
        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
=======
>>>>>>> 5ea82dc (.)
    public function testPerformanceWithLargeJsonFiles(): void
    {
        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 1000; ++$i) {
<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
<<<<<<< HEAD
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
=======
<<<<<<< HEAD
                'status' => ($i % 2 === 0) ? 'active' : 'inactive',
=======
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
                'metadata' => ['key' => "value_{$i}"],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);
        
        $executionTime = ($endTime - $startTime) * 1000; // Converti in millisecondi
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));

        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000; // Converti in millisecondi

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertCount(1000, $rows);
        $this->assertLessThan(100, $executionTime, 'Caricamento file JSON troppo lento');
    }

    /**
     * Test per la gestione della memoria con file JSON grandi.
     */
<<<<<<< HEAD
=======
<<<<<<< HEAD
    public function test_memory_usage_with_large_json_files(): void
    {
        $initialMemory = memory_get_usage();
        
        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 500; $i++) {
=======
>>>>>>> 5ea82dc (.)
    public function testMemoryUsageWithLargeJsonFiles(): void
    {
        $initialMemory = memory_get_usage();

        // Crea dati di test con molteplici record
        $largeData = [];
        for ($i = 1; $i <= 500; ++$i) {
<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
                'status' => 'active',
                'metadata' => ['key' => "value_{$i}"],
            ];
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD
        
        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));
        
        $rows = $this->model->getSushiRows();
        
        $finalMemory = memory_get_usage();
        $memoryUsed = $finalMemory - $initialMemory;
        
=======
>>>>>>> 5ea82dc (.)

        File::put($this->testJsonPath, json_encode($largeData, JSON_PRETTY_PRINT));

        $rows = $this->model->getSushiRows();

        $finalMemory = memory_get_usage();
        $memoryUsed = $finalMemory - $initialMemory;

<<<<<<< HEAD
=======
>>>>>>> 6fc381b (.)
>>>>>>> 5ea82dc (.)
        $this->assertCount(500, $rows);
        $this->assertLessThan(50 * 1024 * 1024, $memoryUsed, 'Utilizzo memoria eccessivo (>50MB)');
    }
}
