<?php

declare(strict_types=1);

namespace Modules\Reporting\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ReportData model per i dati dettagliati dei report.
 */
class ReportData extends BaseModel
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'report_id',
        'key',
        'value',
        'data_type',
        'description',
        'order',
        'group',
        'metadata',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'json',
        'metadata' => 'array',
        'order' => 'integer',
    ];

    /**
     * Relazione con il report principale.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Scope per filtrare i dati per gruppo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope per filtrare i dati per tipo di dato.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $dataType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDataType($query, string $dataType)
    {
        return $query->where('data_type', $dataType);
    }

    /**
     * Scope per ordinare i dati in base al campo order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Ottiene il valore tipizzato in base al data_type.
     *
     * @return mixed
     */
    public function getTypedValue(): mixed
    {
        return match ($this->data_type) {
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'boolean' => (bool) $this->value,
            'date' => new \DateTime($this->value),
            'array', 'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
