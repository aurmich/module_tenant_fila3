<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('patient', PatientController::class)->names('patient');
<<<<<<< HEAD
    
    // Rotta per il salvataggio temporaneo dei dati del wizard
    Route::post('patient/save-draft', [PatientController::class, 'saveDraft'])->name('patient.save-draft');
=======
>>>>>>> 2004ea4c (.)
});
