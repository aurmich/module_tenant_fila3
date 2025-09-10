# SushiToJson Trait (Tenant)

Status: stable – unit tested (5 tests)

## Purpose
- Read/write tenant-scoped JSON files as backing store for Sushi in-memory models.
- Keep IDs stable and manage timestamps/audit fields.

## Files and paths
- Path builder: `Modules/Tenant/Services/TenantService::filePath()`
- Storage: `config/{tenant}/database/content/{table}.json`

## Key methods
- `getJsonFile(): string` – resolves JSON file path for current model table
- `getRows(): array` – delegates to `getSushiRows()` for Sushi
- `getSushiRows(): array` – loads file, normalizes nested arrays to JSON strings
- `saveToJson(array $rows): bool` – persists rows with pretty JSON
- `loadExistingData(): array` – reads file (raw), used by lifecycle events
- `bootSushiToJson()` – Eloquent events for create/update/delete
- `findRowIndexById(array $rows, int $id): ?int` – locate row index by id

## Lifecycle behavior
- create: computes next id scanning existing rows; sets `created_at`, `updated_at`, and optionally `created_by`, `updated_by` if available
- update: finds record by `id` and replaces it; sets `updated_at`, optionally `updated_by`
- delete: removes by `id` and reindexes array (0..n) to satisfy Sushi

## Schema expectations
Model must expose a schema compatible with fields you write into JSON (e.g. `id`, `name`, `description`, `status`, `metadata`, timestamps, audit fields if used). Example test model: `Modules/Tenant/app/Models/TestSushiModel.php`.

## Testing guidelines
- Do NOT use `RefreshDatabase`. Prefer pure unit tests and filesystem setup/cleanup.
- Ensure JSON file is cleaned before each test and removed after (see `SushiToJsonTest`).
- Validate:
  - create assigns incremental `id`
  - update replaces same `id`, updates timestamps
  - delete removes record and reindexes
  - nested arrays become JSON strings for Sushi rows but are cast back to arrays on the model

## Example
```php
$m = new TestSushiModel(name: 'Example', status: 'active', metadata: ['k' => 'v']);
$m->save();

$m->description = 'Updated';
$m->save();

$m->delete();
```

## Notes
- JSON normalization uses `json_encode` for nested structures in rows for Sushi compatibility.
- Casting back to arrays is handled via model `casts()` for fields like `metadata`.
