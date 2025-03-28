# Import Fixes for GDPR Module

## Duplicate Import Issues

### 1. Duplicate Carbon Import in Consent Model

**Error Message:**
```
Cannot use Illuminate\Support\Carbon as Carbon because the name is already in use
```

**Problem Analysis:**
The `Illuminate\Support\Carbon` class is imported twice in the Consent model file, causing a PHP error about duplicate imports.

**File Location:**
`Modules/Gdpr/Models/Consent.php`

### Fix Implementation:
- Remove the duplicate import statement
- Ensure proper PHPDoc annotations for Carbon type hints
- Maintain consistent import ordering according to PSR standards

### Benefits:
- Eliminates PHP syntax errors
- Improves code quality and maintainability
- Resolves related PHPStan errors
