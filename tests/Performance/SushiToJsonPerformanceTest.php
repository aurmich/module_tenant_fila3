<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Performance;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test di performance per il trait SushiToJson.
 * 
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Tests\TestCase;

/**
 * Test di performance per il trait SushiToJson.
 *
<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
 * Testa le prestazioni del trait con file JSON di diverse dimensioni
 * e verifica che i tempi di esecuzione rimangano accettabili.
 */
class SushiToJsonPerformanceTest extends TestCase
{
    use RefreshDatabase;

    private TestSushiModel $model;
    private string $testJsonPath;
    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        // Configura il modello di test
        $this->model = new TestSushiModel();
        
        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->testDirectory . '/test_sushi.json';
        
        // Crea directory di test
        if (!File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        // Configura il modello di test
        $this->model = new TestSushiModel();

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
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
     * Crea dati di test con dimensioni specifiche.
     */
    private function createTestData(int $recordCount): array
    {
        $data = [];
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        for ($i = 1; $i <= $recordCount; $i++) {
=======
        for ($i = 1; $i <= $recordCount; ++$i) {
>>>>>>> 6fc381b (.)
=======
        for ($i = 1; $i <= $recordCount; ++$i) {
>>>>>>> bf127a0 (.)
=======
        for ($i = 1; $i <= $recordCount; $i++) {
>>>>>>> c50df0e (.)
            $data[$i] = [
                'id' => $i,
                'name' => "Test Item {$i}",
                'description' => "This is a detailed description for test item {$i} with additional information to increase the size of the data",
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                'status' => ($i % 2 === 0) ? 'active' : 'inactive',
                'category' => "Category " . ($i % 10 + 1),
=======
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
                'category' => 'Category '.($i % 10 + 1),
>>>>>>> 6fc381b (.)
=======
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
                'category' => 'Category '.($i % 10 + 1),
>>>>>>> bf127a0 (.)
=======
                'status' => ($i % 2 === 0) ? 'active' : 'inactive',
                'category' => "Category " . ($i % 10 + 1),
>>>>>>> c50df0e (.)
                'priority' => ($i % 5 + 1),
                'tags' => ["tag{$i}", "priority{$i}", "category{$i}"],
                'metadata' => [
                    'created_by' => 'test_user',
                    'department' => 'testing',
                    'location' => 'test_environment',
                    'notes' => "Additional notes for item {$i} to increase data size",
                    'settings' => [
                        'notifications' => true,
                        'auto_save' => false,
                        'backup_frequency' => 'daily',
                    ],
                ],
                'timestamps' => [
                    'created_at' => now()->subDays($i)->toISOString(),
                    'updated_at' => now()->toISOString(),
                    'last_accessed' => now()->subHours($i % 24)->toISOString(),
                ],
                'relationships' => [
                    'parent_id' => $i > 1 ? $i - 1 : null,
                    'children_count' => $i % 3,
                    'related_items' => range(max(1, $i - 2), min($recordCount, $i + 2)),
                ],
            ];
        }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        
=======

>>>>>>> 6fc381b (.)
=======

>>>>>>> bf127a0 (.)
=======
        
>>>>>>> c50df0e (.)
        return $data;
    }

    /**
     * Test per le prestazioni con file JSON piccoli (< 100 record).
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_small_json_files(): void
    {
        $recordCount = 50;
        $testData = $this->createTestData($recordCount);
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithSmallJsonFiles(): void
    {
        $recordCount = 50;
        $testData = $this->createTestData($recordCount);

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertTrue($result);
        $this->assertLessThan(50, $writeTime, "Scrittura file piccolo troppo lenta: {$writeTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertTrue($result);
        $this->assertLessThan(50, $writeTime, "Scrittura file piccolo troppo lenta: {$writeTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(25, $readTime, "Lettura file piccolo troppo lenta: {$readTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(25, $readTime, "Lettura file piccolo troppo lenta: {$readTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(100 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON medi (100-1000 record).
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_medium_json_files(): void
    {
        $recordCount = 500;
        $testData = $this->createTestData($recordCount);
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithMediumJsonFiles(): void
    {
        $recordCount = 500;
        $testData = $this->createTestData($recordCount);

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertTrue($result);
        $this->assertLessThan(200, $writeTime, "Scrittura file medio troppo lenta: {$writeTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertTrue($result);
        $this->assertLessThan(200, $writeTime, "Scrittura file medio troppo lenta: {$writeTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(100, $readTime, "Lettura file medio troppo lenta: {$readTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(100, $readTime, "Lettura file medio troppo lenta: {$readTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON grandi (1000+ record).
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_large_json_files(): void
    {
        $recordCount = 2000;
        $testData = $this->createTestData($recordCount);
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithLargeJsonFiles(): void
    {
        $recordCount = 2000;
        $testData = $this->createTestData($recordCount);

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertTrue($result);
        $this->assertLessThan(500, $writeTime, "Scrittura file grande troppo lenta: {$writeTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertTrue($result);
        $this->assertLessThan(500, $writeTime, "Scrittura file grande troppo lenta: {$writeTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(250, $readTime, "Lettura file grande troppo lenta: {$readTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(250, $readTime, "Lettura file grande troppo lenta: {$readTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(5 * 1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON molto grandi (5000+ record).
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_very_large_json_files(): void
    {
        $recordCount = 5000;
        $testData = $this->createTestData($recordCount);
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithVeryLargeJsonFiles(): void
    {
        $recordCount = 5000;
        $testData = $this->createTestData($recordCount);

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertTrue($result);
        $this->assertLessThan(1000, $writeTime, "Scrittura file molto grande troppo lenta: {$writeTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertTrue($result);
        $this->assertLessThan(1000, $writeTime, "Scrittura file molto grande troppo lenta: {$writeTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(500, $readTime, "Lettura file molto grande troppo lenta: {$readTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(500, $readTime, "Lettura file molto grande troppo lenta: {$readTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(10 * 1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per l'utilizzo della memoria con file JSON di diverse dimensioni.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_memory_usage_with_different_file_sizes(): void
    {
        $recordCounts = [100, 500, 1000, 2000];
        
        foreach ($recordCounts as $recordCount) {
            $testData = $this->createTestData($recordCount);
            File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
            
            $initialMemory = memory_get_usage();
            
            $rows = $this->model->getSushiRows();
            
            $finalMemory = memory_get_usage();
            $memoryUsed = $finalMemory - $initialMemory;
            
            $this->assertCount($recordCount, $rows);
            
            // Verifica che l'utilizzo della memoria sia proporzionale al numero di record
            $expectedMemoryLimit = $recordCount * 1024; // 1KB per record come limite ragionevole
            $this->assertLessThan($expectedMemoryLimit, $memoryUsed, 
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testMemoryUsageWithDifferentFileSizes(): void
    {
        $recordCounts = [100, 500, 1000, 2000];

        foreach ($recordCounts as $recordCount) {
            $testData = $this->createTestData($recordCount);
            File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

            $initialMemory = memory_get_usage();

            $rows = $this->model->getSushiRows();

            $finalMemory = memory_get_usage();
            $memoryUsed = $finalMemory - $initialMemory;

            $this->assertCount($recordCount, $rows);

            // Verifica che l'utilizzo della memoria sia proporzionale al numero di record
            $expectedMemoryLimit = $recordCount * 1024; // 1KB per record come limite ragionevole
            $this->assertLessThan($expectedMemoryLimit, $memoryUsed,
<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
                "Utilizzo memoria eccessivo per {$recordCount} record: {$memoryUsed} bytes (limite: {$expectedMemoryLimit} bytes)");
        }
    }

    /**
     * Test per le prestazioni con operazioni CRUD multiple.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_multiple_crud_operations(): void
    {
        $recordCount = 1000;
        $testData = $this->createTestData($recordCount);
        
        // Salva dati iniziali
        $this->model->saveToJson($testData);
        
        // Test operazioni di aggiornamento multiple
        $updateOperations = 100;
        $startTime = microtime(true);
        
        for ($i = 0; $i < $updateOperations; $i++) {
            $recordId = ($i % $recordCount) + 1;
            $testData[$recordId]['name'] = "Updated Item {$i}";
            $testData[$recordId]['updated_at'] = now()->toISOString();
            
            $this->model->saveToJson($testData);
        }
        
        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $updateOperations;
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithMultipleCrudOperations(): void
    {
        $recordCount = 1000;
        $testData = $this->createTestData($recordCount);

        // Salva dati iniziali
        $this->model->saveToJson($testData);

        // Test operazioni di aggiornamento multiple
        $updateOperations = 100;
        $startTime = microtime(true);

        for ($i = 0; $i < $updateOperations; ++$i) {
            $recordId = ($i % $recordCount) + 1;
            $testData[$recordId]['name'] = "Updated Item {$i}";
            $testData[$recordId]['updated_at'] = now()->toISOString();

            $this->model->saveToJson($testData);
        }

        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $updateOperations;

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        $this->assertLessThan(50, $averageTime, "Tempo medio aggiornamento troppo alto: {$averageTime}ms");
        $this->assertLessThan(5000, $totalTime, "Tempo totale operazioni troppo alto: {$totalTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON con dati nidificati complessi.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_complex_nested_data(): void
    {
        $recordCount = 500;
        $complexData = [];
        
        for ($i = 1; $i <= $recordCount; $i++) {
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithComplexNestedData(): void
    {
        $recordCount = 500;
        $complexData = [];

        for ($i = 1; $i <= $recordCount; ++$i) {
<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
            $complexData[$i] = [
                'id' => $i,
                'name' => "Complex Item {$i}",
                'nested_objects' => [
                    'level1' => [
                        'level2' => [
                            'level3' => [
                                'level4' => [
                                    'level5' => "Deep nested value {$i}",
                                    'array_data' => range(1, 100),
                                    'object_data' => [
                                        'key1' => "value1_{$i}",
                                        'key2' => "value2_{$i}",
                                        'key3' => "value3_{$i}",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'arrays' => [
                    'simple' => range(1, 50),
                    'associative' => array_combine(range(1, 50), range(51, 100)),
                    'mixed' => array_merge(range(1, 25), array_fill_keys(range(26, 50), 'mixed_value')),
                ],
                'metadata' => [
                    'tags' => ["tag{$i}", "complex{$i}", "nested{$i}"],
                    'categories' => ["cat{$i}", "subcat{$i}"],
                    'attributes' => array_fill_keys(range(1, 20), "attr_value_{$i}"),
                ],
            ];
        }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        
=======

>>>>>>> 6fc381b (.)
=======

>>>>>>> bf127a0 (.)
=======
        
>>>>>>> c50df0e (.)
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($complexData);
        $writeTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertTrue($result);
        $this->assertLessThan(300, $writeTime, "Scrittura dati complessi troppo lenta: {$writeTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertTrue($result);
        $this->assertLessThan(300, $writeTime, "Scrittura dati complessi troppo lenta: {$writeTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(150, $readTime, "Lettura dati complessi troppo lenta: {$readTime}ms");
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(150, $readTime, "Lettura dati complessi troppo lenta: {$readTime}ms");

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica normalizzazione array nidificati
        $this->assertIsString($rows[1]['nested_objects']);
        $this->assertIsString($rows[1]['arrays']['simple']);
        $this->assertIsString($rows[1]['metadata']['tags']);
    }

    /**
     * Test per le prestazioni con operazioni concorrenti.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function test_performance_with_concurrent_operations(): void
=======
    public function testPerformanceWithConcurrentOperations(): void
>>>>>>> 6fc381b (.)
=======
    public function testPerformanceWithConcurrentOperations(): void
>>>>>>> bf127a0 (.)
=======
    public function test_performance_with_concurrent_operations(): void
>>>>>>> c50df0e (.)
    {
        $recordCount = 1000;
        $testData = $this->createTestData($recordCount);
        $this->model->saveToJson($testData);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        // Simula operazioni concorrenti
        $concurrentOperations = 10;
        $startTime = microtime(true);
        
        $results = [];
        for ($i = 0; $i < $concurrentOperations; $i++) {
            $results[] = $this->model->getSushiRows();
        }
        
        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $concurrentOperations;
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        // Simula operazioni concorrenti
        $concurrentOperations = 10;
        $startTime = microtime(true);

        $results = [];
        for ($i = 0; $i < $concurrentOperations; ++$i) {
            $results[] = $this->model->getSushiRows();
        }

        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $concurrentOperations;

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        // Verifica che tutte le operazioni abbiano restituito lo stesso risultato
        foreach ($results as $result) {
            $this->assertCount($recordCount, $result);
        }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        
=======

>>>>>>> 6fc381b (.)
=======

>>>>>>> bf127a0 (.)
=======
        
>>>>>>> c50df0e (.)
        $this->assertLessThan(100, $averageTime, "Tempo medio operazioni concorrenti troppo alto: {$averageTime}ms");
        $this->assertLessThan(1000, $totalTime, "Tempo totale operazioni concorrenti troppo alto: {$totalTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON corrotto o malformato.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function test_performance_with_corrupted_json_files(): void
=======
    public function testPerformanceWithCorruptedJsonFiles(): void
>>>>>>> 6fc381b (.)
=======
    public function testPerformanceWithCorruptedJsonFiles(): void
>>>>>>> bf127a0 (.)
=======
    public function test_performance_with_corrupted_json_files(): void
>>>>>>> c50df0e (.)
    {
        // Crea file JSON corrotto
        $corruptedContent = '{"invalid": "json" with syntax error';
        File::put($this->testJsonPath, $corruptedContent);
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        
        $startTime = microtime(true);
        
=======

        $startTime = microtime(true);

>>>>>>> 6fc381b (.)
=======

        $startTime = microtime(true);

>>>>>>> bf127a0 (.)
=======
        
        $startTime = microtime(true);
        
>>>>>>> c50df0e (.)
        try {
            $this->model->getSushiRows();
        } catch (\Exception $e) {
            $exceptionTime = (microtime(true) - $startTime) * 1000;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            
=======

>>>>>>> 6fc381b (.)
=======

>>>>>>> bf127a0 (.)
=======
            
>>>>>>> c50df0e (.)
            // Verifica che l'eccezione sia lanciata rapidamente
            $this->assertLessThan(50, $exceptionTime, "Gestione errore JSON troppo lenta: {$exceptionTime}ms");
            $this->assertStringContainsString('Data is not array', $e->getMessage());
        }
    }

    /**
     * Test per le prestazioni con file JSON vuoto.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_empty_json_files(): void
    {
        // Crea file JSON vuoto
        File::put($this->testJsonPath, '{}');
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithEmptyJsonFiles(): void
    {
        // Crea file JSON vuoto
        File::put($this->testJsonPath, '{}');

        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        $this->assertEmpty($rows);
        $this->assertLessThan(10, $readTime, "Lettura file vuoto troppo lenta: {$readTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON contenente solo array vuoto.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
    public function test_performance_with_empty_array_json_files(): void
    {
        // Crea file JSON con array vuoto
        File::put($this->testJsonPath, '[]');
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)
    public function testPerformanceWithEmptyArrayJsonFiles(): void
    {
        // Crea file JSON con array vuoto
        File::put($this->testJsonPath, '[]');

        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        $this->assertEmpty($rows);
        $this->assertLessThan(10, $readTime, "Lettura array vuoto troppo lenta: {$readTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON contenente dati null.
     */
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function test_performance_with_null_data_json_files(): void
=======
    public function testPerformanceWithNullDataJsonFiles(): void
>>>>>>> 6fc381b (.)
=======
    public function testPerformanceWithNullDataJsonFiles(): void
>>>>>>> bf127a0 (.)
=======
    public function test_performance_with_null_data_json_files(): void
>>>>>>> c50df0e (.)
    {
        // Crea file JSON con dati null
        $nullData = [
            '1' => null,
            '2' => null,
            '3' => null,
        ];
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c50df0e (.)
        
        File::put($this->testJsonPath, json_encode($nullData, JSON_PRETTY_PRINT));
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
<<<<<<< HEAD
=======
=======
>>>>>>> bf127a0 (.)

        File::put($this->testJsonPath, json_encode($nullData, JSON_PRETTY_PRINT));

        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;

<<<<<<< HEAD
>>>>>>> 6fc381b (.)
=======
>>>>>>> bf127a0 (.)
=======
>>>>>>> c50df0e (.)
        $this->assertCount(3, $rows);
        $this->assertLessThan(25, $readTime, "Lettura dati null troppo lenta: {$readTime}ms");
    }
}
