<?php

declare(strict_types=1);

namespace Modules\Dental\Services;

use Modules\Dental\Models\Treatment;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Pregnancy;

/**
 * Service per la gestione dei trattamenti odontoiatrici per pazienti in gravidanza.
 */
class PregnancyTreatmentService
{
    /**
     * Verifica se un paziente è in gravidanza.
     *
     * @param int $patientId
     * @return bool
     */
    public function isPatientPregnant(int $patientId): bool
    {
        return Pregnancy::where('patient_id', $patientId)
            ->whereNull('deleted_at')
            ->exists();
    }
    
    /**
     * Ottiene i dettagli della gravidanza di un paziente.
     *
     * @param int $patientId
     * @return Pregnancy|null
     */
    public function getPregnancyDetails(int $patientId): ?Pregnancy
    {
        return Pregnancy::where('patient_id', $patientId)
            ->whereNull('deleted_at')
            ->first();
    }
    
    /**
     * Verifica se un trattamento è sicuro per una paziente in gravidanza.
     *
     * @param Treatment $treatment
     * @return bool
     */
    public function isTreatmentSafeForPregnancy(Treatment $treatment): bool
    {
        // Se il trattamento è marcato esplicitamente come sicuro per la gravidanza
        if ($treatment->is_pregnancy_safe) {
            return true;
        }
        
        // Lista di tipi di trattamenti sicuri per la gravidanza
        $safeTypes = [
            'check-up',
            'cleaning',
            'emergency',
            'consultation',
            'preventive',
        ];
        
        return in_array($treatment->type, $safeTypes);
    }
    
    /**
     * Ottiene i trattamenti raccomandati per pazienti in gravidanza.
     *
     * @return array
     */
    public function getRecommendedTreatmentsForPregnancy(): array
    {
        return [
            [
                'type' => 'check-up',
                'description' => 'Controllo odontoiatrico di routine',
                'is_pregnancy_safe' => true,
            ],
            [
                'type' => 'cleaning',
                'description' => 'Pulizia dentale professionale',
                'is_pregnancy_safe' => true,
            ],
            [
                'type' => 'preventive',
                'description' => 'Trattamenti preventivi (fluorizzazione)',
                'is_pregnancy_safe' => true,
            ],
            [
                'type' => 'emergency',
                'description' => 'Trattamento di emergenza per dolore o infezione',
                'is_pregnancy_safe' => true,
            ],
            [
                'type' => 'consultation',
                'description' => 'Consulenza odontoiatrica per pazienti in gravidanza',
                'is_pregnancy_safe' => true,
            ],
        ];
    }
    
    /**
     * Ottiene i trattamenti da evitare durante la gravidanza.
     *
     * @return array
     */
    public function getTreatmentsToAvoidDuringPregnancy(): array
    {
        return [
            [
                'type' => 'whitening',
                'description' => 'Sbiancamento dentale',
                'reason' => 'Contiene sostanze chimiche potenzialmente dannose',
                'is_pregnancy_safe' => false,
            ],
            [
                'type' => 'implant',
                'description' => 'Impianti dentali',
                'reason' => 'Procedura chirurgica invasiva',
                'is_pregnancy_safe' => false,
            ],
            [
                'type' => 'orthodontic',
                'description' => 'Trattamenti ortodontici complessi',
                'reason' => 'Stress e discomfort prolungato',
                'is_pregnancy_safe' => false,
            ],
            [
                'type' => 'root_canal',
                'description' => 'Trattamento canalare non urgente',
                'reason' => 'Può essere rimandato dopo la gravidanza se non urgente',
                'is_pregnancy_safe' => false,
            ],
            [
                'type' => 'extraction',
                'description' => 'Estrazione dentale non urgente',
                'reason' => 'Procedura invasiva con rischio di complicazioni',
                'is_pregnancy_safe' => false,
            ],
        ];
    }
    
    /**
     * Ottiene raccomandazioni specifiche per il trimestre di gravidanza.
     *
     * @param int $trimester
     * @return array
     */
    public function getTrimesterSpecificRecommendations(int $trimester): array
    {
        switch ($trimester) {
            case 1:
                return [
                    'safe_treatments' => ['check-up', 'cleaning', 'emergency', 'consultation'],
                    'avoid_treatments' => ['extraction', 'implant', 'root_canal', 'whitening', 'orthodontic'],
                    'recommendations' => [
                        'Evitare radiografie non urgenti',
                        'Informare il dentista della gravidanza',
                        'Monitorare eventuali cambiamenti gengivali',
                    ],
                ];
            case 2:
                return [
                    'safe_treatments' => ['check-up', 'cleaning', 'emergency', 'consultation', 'preventive'],
                    'avoid_treatments' => ['implant', 'whitening', 'orthodontic'],
                    'recommendations' => [
                        'Periodo ideale per trattamenti dentali necessari',
                        'Mantenere un'igiene orale rigorosa',
                        'Possibile aumento dell'infiammazione gengivale',
                    ],
                ];
            case 3:
                return [
                    'safe_treatments' => ['check-up', 'cleaning', 'emergency', 'consultation'],
                    'avoid_treatments' => ['extraction', 'implant', 'root_canal', 'whitening', 'orthodontic'],
                    'recommendations' => [
                        'Evitare procedure lunghe e scomode',
                        'Posizionamento attento sulla poltrona odontoiatrica',
                        'Rimandare trattamenti non urgenti dopo il parto',
                    ],
                ];
            default:
                return [
                    'safe_treatments' => ['check-up', 'cleaning', 'emergency', 'consultation', 'preventive'],
                    'avoid_treatments' => ['extraction', 'implant', 'root_canal', 'whitening', 'orthodontic'],
                    'recommendations' => [
                        'Consultare il ginecologo prima di qualsiasi trattamento',
                        'Informare il dentista della gravidanza',
                        'Mantenere un'igiene orale rigorosa',
                    ],
                ];
        }
    }
}