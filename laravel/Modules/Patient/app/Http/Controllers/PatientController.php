<?php

declare(strict_types=1);

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Patient\Models\Patient;
use Modules\Tenant\Traits\BelongsToTenant;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('patient::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Recupera i dati del paziente dalla sessione se esistono
        $patientData = Session::get('patient_data', []);
        $currentStep = Session::get('current_step', 1);
        
        return view('patient::pages.patient.create', compact('patientData', 'currentStep'));
    }

    /**
     * Salva temporaneamente i dati del paziente durante il processo di wizard.
     */
    public function saveDraft(Request $request)
    {
        // Salva i dati del form nella sessione
        $patientData = $request->except(['_token', 'current_step']);
        Session::put('patient_data', $patientData);
        Session::put('current_step', $request->input('current_step', 1));
        
        return response()->json([
            'success' => true,
            'message' => 'Dati salvati temporaneamente',
            'current_step' => $request->input('current_step', 1)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validazione dei dati
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'email' => 'required|email|max:255|unique:patients,email',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_pregnant' => 'nullable|boolean',
            'isee_code' => 'nullable|string|max:255',
            'isee_value' => 'nullable|numeric|min:0',
            'isee_expiry_date' => 'nullable|date',
            'notes' => 'nullable|string|max:65535',
            'privacy_consent' => 'required|accepted',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('patient.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        // Creazione del paziente
        $patient = new Patient();
        $patient->fill($request->all());
        $patient->tenant_id = auth()->user()?->tenant_id ?? 1; // Assegna il tenant dell'utente autenticato o default
        $patient->save();
        
        // Pulisci i dati della sessione
        Session::forget(['patient_data', 'current_step']);
        
        // Redirect con messaggio di successo
        return redirect()
            ->route('patient.show', $patient->id)
            ->with('success', 'Paziente registrato con successo');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient::show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient::edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validazione dei dati
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'fiscal_code' => 'required|string|size:16|unique:patients,fiscal_code,' . $id,
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'email' => 'required|email|max:255|unique:patients,email,' . $id,
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'province' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_pregnant' => 'nullable|boolean',
            'isee_code' => 'nullable|string|max:255',
            'isee_value' => 'nullable|numeric|min:0',
            'isee_expiry_date' => 'nullable|date',
            'notes' => 'nullable|string|max:65535',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('patient.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Aggiornamento del paziente
        $patient = Patient::findOrFail($id);
        $patient->fill($request->all());
        $patient->save();
        
        // Redirect con messaggio di successo
        return redirect()
            ->route('patient.show', $patient->id)
            ->with('success', 'Paziente aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        
        return redirect()
            ->route('patient.index')
            ->with('success', 'Paziente eliminato con successo');
    }
}
