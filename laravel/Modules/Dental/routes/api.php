<?php

use Illuminate\Support\Facades\Route;
use Modules\Dental\Http\Controllers\PregnancyTreatmentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('dental', DentalController::class)->names('dental');
});

Route::middleware(['auth:sanctum'])->prefix('v1/dental')->group(function () {
    // Rotte per i trattamenti in gravidanza
    Route::prefix('pregnancy')->group(function () {
        Route::get('patient/{patientId}/status', [PregnancyTreatmentController::class, 'checkPregnancyStatus']);
        Route::get('patient/{patientId}/details', [PregnancyTreatmentController::class, 'getPregnancyDetails']);
        Route::get('patient/{patientId}/recommendations', [PregnancyTreatmentController::class, 'getPatientSpecificRecommendations']);
        Route::get('treatment/{treatmentId}/safety', [PregnancyTreatmentController::class, 'checkTreatmentSafety']);
        Route::get('recommended-treatments', [PregnancyTreatmentController::class, 'getRecommendedTreatments']);
        Route::get('treatments-to-avoid', [PregnancyTreatmentController::class, 'getTreatmentsToAvoid']);
        Route::get('trimester/{trimester}/recommendations', [PregnancyTreatmentController::class, 'getTrimesterRecommendations']);
    });
});
