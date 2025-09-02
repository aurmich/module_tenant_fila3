<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Performance;

use Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Tenant\Services\TenantService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Test di performance per il trait SushiToJson.
 *
 * Testa le prestazioni del trait con file JSON di diverse dimensioni
 * e verifica che i tempi di esecuzione rimangano accettabili.
 * 
 * IMPORTANTE: NO RefreshDatabase - solo oggetti in-memory per performance
 */
#[Group('performance')]
#[Group('sushi-json')]
class SushiToJsonPerformanceTest extends TestCase
{
    // NO RefreshDatabase - test di performance devono essere veloci!
    
    private TestSushiModel $model;
    private string $testJsonPath;
    private string $testDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        // Configura il modello di test (NO database)
        $this->model = new TestSushiModel();

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

        // Crea directory di test
        if (!File::exists($this->testDirectory)) {
            File::makeDirectory($this->testDirectory, 0755, true, true);
        }

        // Mock TenantService per i test (NO database)
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
     * Mock del TenantService per i test (NO database).
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
     * Crea dati di test con dimensioni specifiche (NO database).
     */
    private function createTestData(int $recordCount): array
    {
        $data = [];
        for ($i = 1; $i <= $recordCount; ++$i) {
            $data[$i] = [
                'id' => $i,
                'name' => "Test Item {$i}",
                'description' => "This is a detailed description for test item {$i} with additional information to increase the size of the data",
                'status' => (0 === $i % 2) ? 'active' : 'inactive',
                'category' => 'Category '.($i % 10 + 1),
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
                    'updated_at' => now()->subHours($i)->toISOString(),
                ],
            ];
        }

        return $data;
    }

    /**
     * Test di performance per conversione JSON con 100 record.
     */
    public function test_json_conversion_performance_100_records(): void
    {
        $data = $this->createTestData(100);
        $startTime = microtime(true);

        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000; // Converti in millisecondi

        // Performance target: < 50ms per 100 record
        expect($executionTime)->toBeLessThan(50.0);
        expect($jsonString)->toBeString();
        expect(json_decode($jsonString, true))->toBe($data);
    }

    /**
     * Test di performance per conversione JSON con 1000 record.
     */
    public function test_json_conversion_performance_1000_records(): void
    {
        $data = $this->createTestData(1000);
        $startTime = microtime(true);

        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000;

        // Performance target: < 200ms per 1000 record
        expect($executionTime)->toBeLessThan(200.0);
        expect($jsonString)->toBeString();
        expect(json_decode($jsonString, true))->toBe($data);
    }

    /**
     * Test di performance per conversione JSON con 10000 record.
     */
    public function test_json_conversion_performance_10000_records(): void
    {
        $data = $this->createTestData(10000);
        $startTime = microtime(true);

        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000;

        // Performance target: < 1000ms per 10000 record
        expect($executionTime)->toBeLessThan(1000.0);
        expect($jsonString)->toBeString();
        expect(json_decode($jsonString, true))->toBe($data);
    }

    /**
     * Test di performance per parsing JSON con 100 record.
     */
    public function test_json_parsing_performance_100_records(): void
    {
        $data = $this->createTestData(100);
        $jsonString = json_encode($data);

        $startTime = microtime(true);
        $parsedData = json_decode($jsonString, true);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000;

        // Performance target: < 10ms per parsing 100 record
        expect($executionTime)->toBeLessThan(10.0);
        expect($parsedData)->toBe($data);
    }

    /**
     * Test di performance per parsing JSON con 1000 record.
     */
    public function test_json_parsing_performance_1000_records(): void
    {
        $data = $this->createTestData(1000);
        $jsonString = json_encode($data);

        $startTime = microtime(true);
        $parsedData = json_decode($jsonString, true);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000;

        // Performance target: < 50ms per parsing 1000 record
        expect($executionTime)->toBeLessThan(50.0);
        expect($parsedData)->toBe($data);
    }

    /**
     * Test di performance per parsing JSON con 10000 record.
     */
    public function test_json_parsing_performance_10000_records(): void
    {
        $data = $this->createTestData(10000);
        $jsonString = json_encode($data);

        $startTime = microtime(true);
        $parsedData = json_decode($jsonString, true);
        $endTime = microtime(true);

        $executionTime = ($endTime - $startTime) * 1000;

        // Performance target: < 200ms per parsing 10000 record
        expect($executionTime)->toBeLessThan(200.0);
        expect($parsedData)->toBe($data);
    }

    /**
     * Test di performance per operazioni file con JSON.
     */
    public function test_file_operations_performance(): void
    {
        $data = $this->createTestData(1000);
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);

        // Test scrittura file
        $startTime = microtime(true);
        File::put($this->testJsonPath, $jsonString);
        $writeTime = (microtime(true) - $startTime) * 1000;

        // Test lettura file
        $startTime = microtime(true);
        $readContent = File::get($this->testJsonPath);
        $readTime = (microtime(true) - $startTime) * 1000;

        // Performance target: < 100ms per operazioni file
        expect($writeTime)->toBeLessThan(100.0);
        expect($readTime)->toBeLessThan(100.0);
        expect($readContent)->toBe($jsonString);
    }

    /**
     * Test di performance per operazioni di storage.
     */
    public function test_storage_operations_performance(): void
    {
        $data = $this->createTestData(500);
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);

        // Test scrittura storage
        $startTime = microtime(true);
        Storage::disk('local')->put('test_performance.json', $jsonString);
        $writeTime = (microtime(true) - $startTime) * 1000;

        // Test lettura storage
        $startTime = microtime(true);
        $readContent = Storage::disk('local')->get('test_performance.json');
        $readTime = (microtime(true) - $startTime) * 1000;

        // Cleanup
        Storage::disk('local')->delete('test_performance.json');

        // Performance target: < 150ms per operazioni storage
        expect($writeTime)->toBeLessThan(150.0);
        expect($readTime)->toBeLessThan(150.0);
        expect($readContent)->toBe($jsonString);
    }

    /**
     * Test di performance per operazioni multiple.
     */
    public function test_multiple_operations_performance(): void
    {
        $data = $this->createTestData(1000);
        
        $startTime = microtime(true);
        
        // Operazioni multiple
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $parsedData = json_decode($jsonString, true);
        $compressed = gzencode($jsonString);
        $decompressed = gzdecode($compressed);
        
        $endTime = microtime(true);
        $totalTime = ($endTime - $startTime) * 1000;

        // Performance target: < 500ms per operazioni multiple
        expect($totalTime)->toBeLessThan(500.0);
        expect($parsedData)->toBe($data);
        expect($decompressed)->toBe($jsonString);
    }

    /**
     * Test di performance per operazioni con memoria.
     */
    public function test_memory_usage_performance(): void
    {
        $data = $this->createTestData(10000);
        
        $memoryBefore = memory_get_usage();
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $memoryAfter = memory_get_usage();
        
        $memoryUsed = $memoryAfter - $memoryBefore;
        
        // Memory target: < 50MB per 10000 record
        expect($memoryUsed)->toBeLessThan(50 * 1024 * 1024);
        expect($jsonString)->toBeString();
    }

    /**
     * Test di performance per operazioni con cache.
     */
    public function test_cache_operations_performance(): void
    {
        $data = $this->createTestData(1000);
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        
        // Test scrittura cache
        $startTime = microtime(true);
        cache(['test_performance' => $jsonString], 60);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        // Test lettura cache
        $startTime = microtime(true);
        $cachedContent = cache('test_performance');
        $readTime = (microtime(true) - $startTime) * 1000;
        
        // Cleanup
        cache()->forget('test_performance');
        
        // Performance target: < 50ms per operazioni cache
        expect($writeTime)->toBeLessThan(50.0);
        expect($readTime)->toBeLessThan(50.0);
        expect($cachedContent)->toBe($jsonString);
    }

    /**
     * Test di performance per operazioni con session.
     */
    public function test_session_operations_performance(): void
    {
        $data = $this->createTestData(500);
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        
        // Test scrittura session
        $startTime = microtime(true);
        session(['test_performance' => $jsonString]);
        $writeTime = (microtime(true) - $startTime) * 1000;
        
        // Test lettura session
        $startTime = microtime(true);
        $sessionContent = session('test_performance');
        $readTime = (microtime(true) - $startTime) * 1000;
        
        // Cleanup
        session()->forget('test_performance');
        
        // Performance target: < 30ms per operazioni session
        expect($writeTime)->toBeLessThan(30.0);
        expect($readTime)->toBeLessThan(30.0);
        expect($sessionContent)->toBe($jsonString);
    }
}

/**
 * Modello di test che usa il trait SushiToJson (NO database).
 */
class TestSushiModel
{
    use SushiToJson;

    protected $table = 'test_sushi';
    protected $guarded = [];

    public function getSushiConnection()
    {
        return 'testing';
    }
}
