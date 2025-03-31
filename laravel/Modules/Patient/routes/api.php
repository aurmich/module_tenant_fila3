<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('api/v1/patient')
    ->group(function () {
        Route::apiResource('patients', 'Api\PatientController');
        Route::apiResource('patients.documents', 'Api\DocumentController');
        Route::apiResource('patients.anamnesis', 'Api\AnamnesisController');
    }); 