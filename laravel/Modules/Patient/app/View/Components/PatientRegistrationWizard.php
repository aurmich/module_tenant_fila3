<?php

declare(strict_types=1);

namespace Modules\Patient\View\Components;

use Illuminate\View\Component;
use Modules\Patient\Models\Patient;

class PatientRegistrationWizard extends Component
{
    /**
     * Numero di step totali nel wizard.
     */
    public int $totalSteps = 4;
    
    /**
     * Step corrente del wizard.
     */
    public int $currentStep = 1;
    
    /**
     * Dati temporanei del paziente.
     */
    public array $patientData = [];
    
    /**
     * Indica se il form è stato inviato.
     */
    public bool $isSubmitted = false;
    
    /**
     * Create the component instance.
     */
    public function __construct(int $currentStep = 1, array $patientData = [])
    {
        $this->currentStep = $currentStep;
        $this->patientData = $patientData;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('patient::components.patient-registration-wizard');
    }
    
    /**
     * Restituisce il titolo dello step corrente.
     */
    public function getStepTitle(): string
    {
        return match($this->currentStep) {
            1 => 'Dati Anagrafici',
            2 => 'Contatti e Indirizzo',
            3 => 'Dati ISEE',
            4 => 'Conferma Dati',
            default => 'Registrazione Paziente',
        };
    }
    
    /**
     * Restituisce la descrizione dello step corrente.
     */
    public function getStepDescription(): string
    {
        return match($this->currentStep) {
            1 => 'Inserisci i dati anagrafici del paziente',
            2 => 'Inserisci i contatti e l\'indirizzo del paziente',
            3 => 'Inserisci i dati ISEE (opzionale)',
            4 => 'Verifica i dati inseriti prima di completare la registrazione',
            default => 'Completa tutti i campi richiesti',
        };
    }
    
    /**
     * Verifica se lo step corrente è valido.
     */
    public function isStepValid(): bool
    {
        return match($this->currentStep) {
            1 => $this->isStep1Valid(),
            2 => $this->isStep2Valid(),
            3 => true, // Lo step 3 è opzionale
            4 => true, // Lo step 4 è solo di conferma
            default => false,
        };
    }
    
    /**
     * Verifica se lo step 1 è valido.
     */
    private function isStep1Valid(): bool
    {
        return isset($this->patientData['name']) && 
               isset($this->patientData['surname']) && 
               isset($this->patientData['fiscal_code']) && 
               isset($this->patientData['birth_date']);
    }
    
    /**
     * Verifica se lo step 2 è valido.
     */
    private function isStep2Valid(): bool
    {
        return isset($this->patientData['email']) && 
               isset($this->patientData['phone']);
    }
}
