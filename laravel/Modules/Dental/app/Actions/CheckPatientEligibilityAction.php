<?php

declare(strict_types=1);

namespace Modules\Dental\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\PatientIsee;
use Spatie\QueueableAction\QueueableAction;

/**
 * Azione per verificare l'idoneità di una paziente al programma SaluteOra.
 * 
 * Una paziente è idonea se:
 * - È in stato di gravidanza
 * - Ha un valore ISEE inferiore a 20.000 euro
 */
class CheckPatientEligibilityAction
{
    use QueueableAction;

    /**
     * Valore ISEE massimo per l'idoneità.
     */
    protected const MAX_ISEE_VALUE = 20000;

    /**
     * Verifica l'idoneità di una paziente al programma.
     * 
     * @param Patient $patient La paziente da verificare
     * @return array<string, mixed> Risultato della verifica
     */
    public function execute(Patient $patient): array
    {
        Log::info('Verifica idoneità paziente', ['patient_id' => $patient->id]);

        $isPregnant = $this->checkPregnancyStatus($patient);
        $iseeVerification = $this->checkIseeValue($patient);

        $isEligible = $isPregnant && $iseeVerification['valid'];
        $reason = $this->getIneligibilityReason($isPregnant, $iseeVerification);

        return [
            'eligible' => $isEligible,
            'reason' => $reason,
            'pregnancy_status' => $isPregnant,
            'isee' => $iseeVerification,
        ];
    }

    /**
     * Verifica se la paziente è in stato di gravidanza.
     * 
     * @param Patient $patient La paziente da verificare
     * @return bool
     */
    protected function checkPregnancyStatus(Patient $patient): bool
    {
        // Controlla se il campo pregnancy_status è impostato a true
        // Nella versione completa, questa logica potrebbe essere più complessa e includere
        // la verifica della data presunta del parto
        return (bool) ($patient->pregnancy_status ?? false);
    }

    /**
     * Verifica il valore ISEE della paziente.
     * 
     * @param Patient $patient La paziente da verificare
     * @return array<string, mixed>
     */
    protected function checkIseeValue(Patient $patient): array
    {
        // Ottiene l'ultimo ISEE registrato per la paziente
        $latestIsee = PatientIsee::where('patient_id', $patient->id)
            ->where('valid_until', '>=', now())
            ->orderByDesc('created_at')
            ->first();

        if (!$latestIsee) {
            return [
                'valid' => false,
                'value' => null,
                'missing' => true,
                'expired' => false,
                'reason' => 'Nessuna dichiarazione ISEE trovata per questa paziente.',
            ];
        }

        // Verifica se il valore ISEE è inferiore alla soglia
        $iseeValue = $latestIsee->value;
        $isValid = $iseeValue <= self::MAX_ISEE_VALUE;

        return [
            'valid' => $isValid,
            'value' => $iseeValue,
            'missing' => false,
            'expired' => false,
            'threshold' => self::MAX_ISEE_VALUE,
            'reason' => $isValid ? null : 'Il valore ISEE supera la soglia massima per l\'accesso al programma.',
        ];
    }

    /**
     * Ottiene il motivo dell'inidoneità, se applicabile.
     * 
     * @param bool $isPregnant Stato di gravidanza
     * @param array<string, mixed> $iseeVerification Risultato verifica ISEE
     * @return string|null
     */
    protected function getIneligibilityReason(bool $isPregnant, array $iseeVerification): ?string
    {
        if (!$isPregnant && !$iseeVerification['valid']) {
            return 'La paziente non è in stato di gravidanza e il valore ISEE supera la soglia massima.';
        }

        if (!$isPregnant) {
            return 'La paziente non è in stato di gravidanza.';
        }

        if (!$iseeVerification['valid']) {
            return $iseeVerification['reason'] ?? 'ISEE non valido per l\'accesso al programma.';
        }

        return null;
    }
}
