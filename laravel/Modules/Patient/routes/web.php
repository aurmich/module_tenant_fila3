<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'role:doctor|admin'])
    ->prefix('patient')
    ->group(function () {
        Route::get('/', 'PatientController@index')->name('patient.index');
        Route::get('/create', 'PatientController@create')->name('patient.create');
        Route::post('/', 'PatientController@store')->name('patient.store');
        Route::get('/{patient}', 'PatientController@show')->name('patient.show');
        Route::get('/{patient}/edit', 'PatientController@edit')->name('patient.edit');
        Route::put('/{patient}', 'PatientController@update')->name('patient.update');
        Route::delete('/{patient}', 'PatientController@destroy')->name('patient.destroy');

        Route::get('/{patient}/documents', 'DocumentController@index')->name('patient.documents.index');
        Route::get('/{patient}/documents/create', 'DocumentController@create')->name('patient.documents.create');
        Route::post('/{patient}/documents', 'DocumentController@store')->name('patient.documents.store');
        Route::get('/{patient}/documents/{document}', 'DocumentController@show')->name('patient.documents.show');
        Route::get('/{patient}/documents/{document}/edit', 'DocumentController@edit')->name('patient.documents.edit');
        Route::put('/{patient}/documents/{document}', 'DocumentController@update')->name('patient.documents.update');
        Route::delete('/{patient}/documents/{document}', 'DocumentController@destroy')->name('patient.documents.destroy');

        Route::get('/{patient}/anamnesis', 'AnamnesisController@index')->name('patient.anamnesis.index');
        Route::get('/{patient}/anamnesis/create', 'AnamnesisController@create')->name('patient.anamnesis.create');
        Route::post('/{patient}/anamnesis', 'AnamnesisController@store')->name('patient.anamnesis.store');
        Route::get('/{patient}/anamnesis/{anamnesis}', 'AnamnesisController@show')->name('patient.anamnesis.show');
        Route::get('/{patient}/anamnesis/{anamnesis}/edit', 'AnamnesisController@edit')->name('patient.anamnesis.edit');
        Route::put('/{patient}/anamnesis/{anamnesis}', 'AnamnesisController@update')->name('patient.anamnesis.update');
        Route::delete('/{patient}/anamnesis/{anamnesis}', 'AnamnesisController@destroy')->name('patient.anamnesis.destroy');
    }); 