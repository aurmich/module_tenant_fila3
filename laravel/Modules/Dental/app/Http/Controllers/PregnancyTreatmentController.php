<?php

declare(strict_types=1);

namespace Modules\Dental\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dental\Models\Treatment;
use Modules\Dental\Services\PregnancyTreatmentService;
use Modules\Patient\Models\Patient;
use Modules\Patient\Models\Pregnancy;

/**
 * Controller per la gestione dei trattamenti odontoiatrici per pazienti in gravidanza.
 */
class PregnancyTreatmentController extends Controller
{
    /**
     * Il service per la gestione dei trattamenti in gravidanza.
     *
     * @var PregnancyTreatmentService
     */
    protected PregnancyTreatmentService $pregnancyTreatmentService;

    /**
     * Costruttore.
     *
     * @param PregnancyTreatmentService $pregnancyTreatmentService
     */
    public function __construct(PregnancyTreatmentService $pregnancyTreatmentService)
    {
        $this->pregnancyTreatmentService = $pregnancyTreatmentService;
    }

    /**
     * Verifica se un paziente è in gravidanza.
     *
     * @param int $patientId
     * @return JsonResponse
     */
    public function checkPregnancyStatus(int $patientId): JsonResponse
    {
        $isPregnant = $this->pregnancyTreatmentService->isPatientPregnant($patientId);
        
        return response()->json([
            'is_pregnant' => $isPregnant,
        ]);
    }

    /**
     * Ottiene i dettagli della gravidanza di un paziente.
     *
     * @param int $patientId
     * @return JsonResponse
     */
    public function getPregnancyDetails(int $patientId): JsonResponse
    {
        $pregnancy = $this->pregnancyTreatmentService->getPregnancyDetails($patientId);
        
        if (!$pregnancy) {
            return response()->json([
                'message' => 'Nessuna gravidanza trovata per questo paziente',
            ], 404);
        }
        
        return response()->json($pregnancy);
    }

    /**
     * Verifica se un trattamento è sicuro per una paziente in gravidanza.
     *
     * @param int $treatmentId
     * @return JsonResponse
     */
    public function checkTreatmentSafety(int $treatmentId): JsonResponse
    {
        $treatment = Treatment::findOrFail($treatmentId);
        $isSafe = $this->pregnancyTreatmentService->isTreatmentSafeForPregnancy($treatment);
        
        return response()->json([
            'is_safe' => $isSafe,
        ]);
    }

    /**
     * Ottiene i trattamenti raccomandati per pazienti in gravidanza.
     *
     * @return JsonResponse
     */
    public function getRecommendedTreatments(): JsonResponse
    {
        $recommendedTreatments = $this->pregnancyTreatmentService->getRecommendedTreatmentsForPregnancy();
        
        return response()->json($recommendedTreatments);
    }

    /**
     * Ottiene i trattamenti da evitare durante la gravidanza.
     *
     * @return JsonResponse
     */
    public function getTreatmentsToAvoid(): JsonResponse
    {
        $treatmentsToAvoid = $this->pregnancyTreatmentService->getTreatmentsToAvoidDuringPregnancy();
        
        return response()->json($treatmentsToAvoid);
    }

    /**
     * Ottiene raccomandazioni specifiche per il trimestre di gravidanza.
     *
     * @param int $trimester
     * @return JsonResponse
     */
    public function getTrimesterRecommendations(int $trimester): JsonResponse
    {
        $recommendations = $this->pregnancyTreatmentService->getTrimesterSpecificRecommendations($trimester);
        
        return response()->json($recommendations);
    }

    /**
     * Ottiene raccomandazioni per un paziente specifico in base al suo stato di gravidanza.
     *
     * @param int $patientId
     * @return JsonResponse
     */
    public function getPatientSpecificRecommendations(int $patientId): JsonResponse
    {
        $isPregnant = $this->pregnancyTreatmentService->isPatientPregnant($patientId);
        
        if (!$isPregnant) {
            return response()->json([
                'message' => 'Il paziente non è in gravidanza',
                'recommendations' => [],
            ]);
        }
        
        $pregnancy = $this->pregnancyTreatmentService->getPregnancyDetails($patientId);
        $trimester = $pregnancy->trimester ?? 1;
        
        $recommendations = $this->pregnancyTreatmentService->getTrimesterSpecificRecommendations($trimester);
        
        return response()->json([
            'pregnancy_details' => $pregnancy,
            'recommendations' => $recommendations,
        ]);
    }
}