# SushiToJson – Implementation Plan and Test Strategy

> Context: This plan complements the existing docs at `Modules/Tenant/docs/traits/sushi-to-jsons.md` and the analysis in `Modules/Geo/docs/sushi-to-jsons-analysis.md`. It aligns with TenantService path rules and Boy Scout Rule.

## Goals
- Provide a single-file JSON backing store per table for Sushi models using the `SushiToJson` trait.
- Ensure robust, typed read/write behavior integrated with Eloquent lifecycle events.
- Keep parity with `SushiToJsons` (multi-file) where sensible, but optimized for single JSON file use-cases.

## Business Logic Summary
- Source file path: `TenantService::filePath('database/content/{table}.json')` via `getJsonFile()`.
- `getSushiRows()`
  - If file is missing: return an empty array (no rows).
  - Read JSON as `array<int, array<string, mixed>>`.
  - Normalize nested arrays/objects to pretty-printed JSON strings for Sushi in-memory table constraints.
  - Strict typing + assertions.
- Lifecycle events (boot method name corrected to `bootSushiToJson`):
  - `creating`:
    - Load existing rows (if any), compute incremental `id` (max + 1).
    - Set timestamps (`created_at`, `updated_at`). If project helper `authId()` exists, set `created_by`, `updated_by`.
    - Append new row (use `$model->getAttributes()`), create directory if needed, write back JSON (pretty-printed).
  - `updating`:
    - Load rows, locate row by `id`, merge with `$model->getAttributes()`.
    - Update `updated_at` and `updated_by` (if helper exists), write back JSON.
  - `deleting`:
    - Load rows, remove row with matching `id`, write back JSON. If file missing or malformed, skip silently.

## Differences from SushiToJsons (plural)
- SushiToJsons: 1 file per record (`database/content/{table}/{id}.json`).
- SushiToJson: 1 file per table (`database/content/{table}.json`).
- Same normalization for nested data and similar auditing behavior when helpers exist.

## Error Handling
- Use `thecodingmachine/safe` functions for JSON and file I/O where appropriate.
- Throw explicit exceptions only on malformed JSON during reads; writes should fail fast via Safe functions.
- Directory creation before writes (0755, recursive).

## Type Safety & Standards
- `declare(strict_types=1);`
- Webmozart Assert to validate expectations.
- PSR-12 formatting.
- No debug `dddx()` calls.

## Test Strategy (Pest)
- Location: `Modules/Tenant/tests/Unit/SushiToJsonTest.php`.
- Model: `Modules\Tenant\Models\TestSushiModel` (already present), `protected $table = 'test_sushi'`.
- Arrange: Ensure tenant test path resolves to module Config dir when `isRunningTestBench()` is true (TenantService already supports this).
- Use a temporary file under `Modules/Tenant/app/Config/database/content/test_sushi.json` (auto-resolved by TenantService during tests) and clean it up between tests.

### Tests
1. Read-empty
   - Given no file exists, `getSushiRows()` returns `[]`.
2. Create-persists
   - `TestSushiModel::create([...])` appends a row, assigns auto-increment `id = 1` and sets timestamps.
   - File contains exactly one row with provided attributes.
3. Update-persists
   - Update the created model; verify merged row is persisted and `updated_at` changes.
4. Delete-persists
   - Delete the record; file no longer contains the row.
5. Nested-data-normalization
   - A `metadata` array is stored raw in file but returned as JSON-encoded string in `getSushiRows()` (Sushi view), ensuring table rows stay scalar-friendly.

## Maintenance Notes
- If later we need optimistic locking or concurrency control, we can add checksum/version fields to rows.
- Keep `SushiToJsons` untouched for multi-file scenarios; this trait targets compact datasets.

## Next Steps
1. Implement `SushiToJson` per this plan.
2. Add Pest tests described above.
3. Run test suite and iterate.
