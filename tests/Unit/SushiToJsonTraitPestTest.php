<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    // Configura il modello di test
<<<<<<< HEAD
<<<<<<< HEAD
    $this->model = new TestSushiModel;
=======
    $this->model = new TestSushiModel();
>>>>>>> fe45b40 (.)
=======
    $this->model = new TestSushiModel();
>>>>>>> 5192c37 (.)

    // Configura percorsi di test
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    // Crea directory di test
    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0755, true, true);
    }

    // Mock TenantService per i test
    $this->mock(TenantService::class, function ($mock) {
        $mock->shouldReceive('filePath')
            ->with('database/content/test_sushi.json')
            ->andReturn($this->testJsonPath);
    });
});

afterEach(function () {
    // Cleanup file di test
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
    }
});

describe('SushiToJson Trait', function () {
<<<<<<< HEAD
<<<<<<< HEAD

=======
    
>>>>>>> fe45b40 (.)
=======
    
>>>>>>> 5192c37 (.)
    it('returns correct json file path', function () {
        $path = $this->model->getJsonFile();

        expect($path)->toBe($this->testJsonPath);
        expect($path)->toEndWith('test_sushi.json');
    })->group('getJsonFile', 'traits', 'sushi-json');

    it('loads existing data from json file', function () {
        $testData = [
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
<<<<<<< HEAD
<<<<<<< HEAD

=======
        
>>>>>>> fe45b40 (.)
=======
        
>>>>>>> 5192c37 (.)
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->loadExistingData();

        expect($rows)->toBeArray();
        expect($rows)->toHaveCount(2);
        expect($rows['1']['name'])->toBe('Test Item 1');
        expect($rows['2']['name'])->toBe('Test Item 2');
    })->group('getSushiRows', 'traits', 'sushi-json');

    it('returns empty array when file not exists', function () {
        $rows = $this->model->getSushiRows();

        expect($rows)->toBeArray();
        expect($rows)->toBeEmpty();
    })->group('getSushiRows', 'traits', 'sushi-json');

    it('throws exception with malformed json', function () {
        File::put($this->testJsonPath, 'invalid json content');

        $this->model->getSushiRows();
    })->throws(\Exception::class, 'Syntax error')
<<<<<<< HEAD
<<<<<<< HEAD
        ->group('getSushiRows', 'traits', 'sushi-json');
=======
      ->group('getSushiRows', 'traits', 'sushi-json');
>>>>>>> fe45b40 (.)
=======
      ->group('getSushiRows', 'traits', 'sushi-json');
>>>>>>> 5192c37 (.)

    it('throws exception with non array data', function () {
        File::put($this->testJsonPath, json_encode('not an array'));

<<<<<<< HEAD
<<<<<<< HEAD
        expect(fn () => $this->model->getSushiRows())
=======
        expect(fn() => $this->model->getSushiRows())
>>>>>>> fe45b40 (.)
=======
        expect(fn() => $this->model->getSushiRows())
>>>>>>> 5192c37 (.)
            ->toThrow(\Exception::class, 'JSON file must contain an array');
    })->group('getSushiRows', 'traits', 'sushi-json');

    it('validates json file structure', function () {
        $validData = [
            '1' => [
                'id' => 1,
                'name' => 'Test Item',
                'status' => 'active',
            ],
        ];
<<<<<<< HEAD
<<<<<<< HEAD

=======
        
>>>>>>> fe45b40 (.)
=======
        
>>>>>>> 5192c37 (.)
        File::put($this->testJsonPath, json_encode($validData));

        $rows = $this->model->getSushiRows();

        expect($rows)->toBeArray();
        expect($rows)->toHaveKey('1');
        expect($rows['1'])->toHaveKey('id');
        expect($rows['1'])->toHaveKey('name');
        expect($rows['1'])->toHaveKey('status');
    })->group('getSushiRows', 'validation', 'traits', 'sushi-json');
});

describe('Business Logic Tests', function () {
<<<<<<< HEAD
<<<<<<< HEAD

=======
    
>>>>>>> fe45b40 (.)
=======
    
>>>>>>> 5192c37 (.)
    it('handles large datasets efficiently', function () {
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData[(string) $i] = [
                'id' => $i,
                'name' => "Item $i",
                'status' => $i % 2 === 0 ? 'active' : 'inactive',
                'created_at' => now()->toISOString(),
            ];
        }
<<<<<<< HEAD
<<<<<<< HEAD

=======
        
>>>>>>> fe45b40 (.)
=======
        
>>>>>>> 5192c37 (.)
        File::put($this->testJsonPath, json_encode($largeData));

        $rows = $this->model->getSushiRows();

        expect($rows)->toHaveCount(1000);
        expect($rows['1']['name'])->toBe('Item 1');
        expect($rows['1000']['name'])->toBe('Item 1000');
    })->group('performance', 'traits', 'sushi-json');

    it('preserves data types correctly', function () {
        $testData = [
            '1' => [
                'id' => 1, // integer
                'name' => 'Test Item', // string
                'active' => true, // boolean
                'price' => 19.99, // float
                'metadata' => ['key' => 'value'], // array
                'created_at' => '2024-01-01T10:00:00Z', // string datetime
            ],
        ];
<<<<<<< HEAD
<<<<<<< HEAD

=======
        
>>>>>>> fe45b40 (.)
=======
        
>>>>>>> 5192c37 (.)
        File::put($this->testJsonPath, json_encode($testData));

        $rows = $this->model->getSushiRows();

        expect($rows['1']['id'])->toBeInt();
        expect($rows['1']['name'])->toBeString();
        expect($rows['1']['active'])->toBeBool();
        expect($rows['1']['price'])->toBeFloat();
        expect($rows['1']['metadata'])->toBeArray();
        expect($rows['1']['created_at'])->toBeString();
    })->group('data-types', 'traits', 'sushi-json');
<<<<<<< HEAD
<<<<<<< HEAD
});
=======
});
>>>>>>> fe45b40 (.)
=======
});
>>>>>>> 5192c37 (.)
