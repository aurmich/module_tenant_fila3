<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test di performance per il trait SushiToJson.
 * 
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
        
        // Configura il modello di test
        $this->model = new TestSushiModel();
        
        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->testDirectory . '/test_sushi.json';
        
        // Crea directory di test
        if (!File::exists($this->testDirectory)) {
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
     * Crea dati di test con dimensioni specifiche.
     */
    private function createTestData(int $recordCount): array
    {
        $data = [];
        for ($i = 1; $i <= $recordCount; $i++) {
            $data[$i] = [
                'id' => $i,
                'name' => "Test Item {$i}",
                'description' => "This is a detailed description for test item {$i} with additional information to increase the size of the data",
                'status' => ($i % 2 === 0) ? 'active' : 'inactive',
                'category' => "Category " . ($i % 10 + 1),
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
        
        return $data;
    }

    /**
     * Test per le prestazioni con file JSON piccoli (< 100 record).
     */
    public function test_performance_with_small_json_files(): void
    {
        $recordCount = 50;
        $testData = $this->createTestData($recordCount);
        
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertTrue($result);
        $this->assertLessThan(50, $writeTime, "Scrittura file piccolo troppo lenta: {$writeTime}ms");
        
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(25, $readTime, "Lettura file piccolo troppo lenta: {$readTime}ms");
        
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(100 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON medi (100-1000 record).
     */
    public function test_performance_with_medium_json_files(): void
    {
        $recordCount = 500;
        $testData = $this->createTestData($recordCount);
        
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertTrue($result);
        $this->assertLessThan(200, $writeTime, "Scrittura file medio troppo lenta: {$writeTime}ms");
        
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(100, $readTime, "Lettura file medio troppo lenta: {$readTime}ms");
        
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON grandi (1000+ record).
     */
    public function test_performance_with_large_json_files(): void
    {
        $recordCount = 2000;
        $testData = $this->createTestData($recordCount);
        
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertTrue($result);
        $this->assertLessThan(500, $writeTime, "Scrittura file grande troppo lenta: {$writeTime}ms");
        
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(250, $readTime, "Lettura file grande troppo lenta: {$readTime}ms");
        
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(5 * 1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per le prestazioni con file JSON molto grandi (5000+ record).
     */
    public function test_performance_with_very_large_json_files(): void
    {
        $recordCount = 5000;
        $testData = $this->createTestData($recordCount);
        
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($testData);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertTrue($result);
        $this->assertLessThan(1000, $writeTime, "Scrittura file molto grande troppo lenta: {$writeTime}ms");
        
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(500, $readTime, "Lettura file molto grande troppo lenta: {$readTime}ms");
        
        // Verifica dimensioni file
        $fileSize = File::size($this->testJsonPath);
        $this->assertLessThan(10 * 1024 * 1024, $fileSize, "File troppo grande per {$recordCount} record: {$fileSize} bytes");
    }

    /**
     * Test per l'utilizzo della memoria con file JSON di diverse dimensioni.
     */
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
                "Utilizzo memoria eccessivo per {$recordCount} record: {$memoryUsed} bytes (limite: {$expectedMemoryLimit} bytes)");
        }
    }

    /**
     * Test per le prestazioni con operazioni CRUD multiple.
     */
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
        
        $this->assertLessThan(50, $averageTime, "Tempo medio aggiornamento troppo alto: {$averageTime}ms");
        $this->assertLessThan(5000, $totalTime, "Tempo totale operazioni troppo alto: {$totalTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON con dati nidificati complessi.
     */
    public function test_performance_with_complex_nested_data(): void
    {
        $recordCount = 500;
        $complexData = [];
        
        for ($i = 1; $i <= $recordCount; $i++) {
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
        
        // Test scrittura
        $startTime = microtime(true);
        $result = $this->model->saveToJson($complexData);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertTrue($result);
        $this->assertLessThan(300, $writeTime, "Scrittura dati complessi troppo lenta: {$writeTime}ms");
        
        // Test lettura
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount($recordCount, $rows);
        $this->assertLessThan(150, $readTime, "Lettura dati complessi troppo lenta: {$readTime}ms");
        
        // Verifica normalizzazione array nidificati
        $this->assertIsString($rows[1]['nested_objects']);
        $this->assertIsString($rows[1]['arrays']['simple']);
        $this->assertIsString($rows[1]['metadata']['tags']);
    }

    /**
     * Test per le prestazioni con operazioni concorrenti.
     */
    public function test_performance_with_concurrent_operations(): void
    {
        $recordCount = 1000;
        $testData = $this->createTestData($recordCount);
        $this->model->saveToJson($testData);
        
        // Simula operazioni concorrenti
        $concurrentOperations = 10;
        $startTime = microtime(true);
        
        $results = [];
        for ($i = 0; $i < $concurrentOperations; $i++) {
            $results[] = $this->model->getSushiRows();
        }
        
        $totalTime = (microtime(true) - $startTime) * 1000;
        $averageTime = $totalTime / $concurrentOperations;
        
        // Verifica che tutte le operazioni abbiano restituito lo stesso risultato
        foreach ($results as $result) {
            $this->assertCount($recordCount, $result);
        }
        
        $this->assertLessThan(100, $averageTime, "Tempo medio operazioni concorrenti troppo alto: {$averageTime}ms");
        $this->assertLessThan(1000, $totalTime, "Tempo totale operazioni concorrenti troppo alto: {$totalTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON corrotto o malformato.
     */
    public function test_performance_with_corrupted_json_files(): void
    {
        // Crea file JSON corrotto
        $corruptedContent = '{"invalid": "json" with syntax error';
        File::put($this->testJsonPath, $corruptedContent);
        
        $startTime = microtime(true);
        
        try {
            $this->model->getSushiRows();
        } catch (\Exception $e) {
            $exceptionTime = (microtime(true) - $startTime) * 1000;
            
            // Verifica che l'eccezione sia lanciata rapidamente
            $this->assertLessThan(50, $exceptionTime, "Gestione errore JSON troppo lenta: {$exceptionTime}ms");
            $this->assertStringContainsString('Data is not array', $e->getMessage());
        }
    }

    /**
     * Test per le prestazioni con file JSON vuoto.
     */
    public function test_performance_with_empty_json_files(): void
    {
        // Crea file JSON vuoto
        File::put($this->testJsonPath, '{}');
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertEmpty($rows);
        $this->assertLessThan(10, $readTime, "Lettura file vuoto troppo lenta: {$readTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON contenente solo array vuoto.
     */
    public function test_performance_with_empty_array_json_files(): void
    {
        // Crea file JSON con array vuoto
        File::put($this->testJsonPath, '[]');
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertEmpty($rows);
        $this->assertLessThan(10, $readTime, "Lettura array vuoto troppo lenta: {$readTime}ms");
    }

    /**
     * Test per le prestazioni con file JSON contenente dati null.
     */
    public function test_performance_with_null_data_json_files(): void
    {
        // Crea file JSON con dati null
        $nullData = [
            '1' => null,
            '2' => null,
            '3' => null,
        ];
        
        File::put($this->testJsonPath, json_encode($nullData, JSON_PRETTY_PRINT));
        
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $readTime = (microtime(true) - $startTime) * 1000;
        
        $this->assertCount(3, $rows);
        $this->assertLessThan(25, $readTime, "Lettura dati null troppo lenta: {$readTime}ms");
    }
}
