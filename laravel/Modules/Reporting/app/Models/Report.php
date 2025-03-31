<?php

declare(strict_types=1);

namespace Modules\Reporting\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;
use Modules\Tenant\Models\Tenant;

/**
 * Report model per la gestione dei report statistici e analitici.
 */
class Report extends BaseModel
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'period_start',
        'period_end',
        'status',
        'created_by',
        'tenant_id',
        'parameters',
        'last_generated_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'period_start' => 'datetime',
        'period_end' => 'datetime',
        'parameters' => 'array',
        'last_generated_at' => 'datetime',
    ];

    /**
     * Relazione con i dati dettagliati del report.
     */
    public function reportData(): HasMany
    {
        return $this->hasMany(ReportData::class);
    }

    /**
     * Relazione con l'utente che ha creato il report.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relazione con il tenant.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope per filtrare i report per tipo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope per filtrare i report per periodo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPeriod($query, string $startDate, string $endDate)
    {
        return $query->where('period_start', '>=', $startDate)
                     ->where('period_end', '<=', $endDate);
    }

    /**
     * Scope per filtrare i report per stato.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
