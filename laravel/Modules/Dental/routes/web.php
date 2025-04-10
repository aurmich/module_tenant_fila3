<?php

use Illuminate\Support\Facades\Route;
use Modules\Dental\Http\Controllers\DentalController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dental', DentalController::class)->names('dental');
});
