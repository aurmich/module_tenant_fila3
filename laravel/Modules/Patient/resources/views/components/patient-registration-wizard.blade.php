<div class="patient-registration-wizard">
    <div class="wizard-header mb-6">
        <h2 class="text-2xl font-bold">{{ $getStepTitle() }}</h2>
        <p class="text-gray-600">{{ $getStepDescription() }}</p>
        
        <div class="wizard-progress mt-4">
            <div class="flex items-center justify-between">
                @for ($i = 1; $i <= $totalSteps; $i++)
                    <div class="step-indicator flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $i <= $currentStep ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            {{ $i }}
                        </div>
                        <div class="text-xs mt-2 {{ $i <= $currentStep ? 'text-blue-600 font-semibold' : 'text-gray-500' }}">
                            @switch($i)
                                @case(1)
                                    Anagrafica
                                    @break
                                @case(2)
                                    Contatti
                                    @break
                                @case(3)
                                    ISEE
                                    @break
                                @case(4)
                                    Conferma
                                    @break
                            @endswitch
                        </div>
                    </div>
                    
                    @if ($i < $totalSteps)
                        <div class="flex-1 h-1 mx-2 {{ $i < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                @endfor
            </div>
        </div>
    </div>

    <form id="patientRegistrationForm" method="POST" action="{{ route('patient.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="current_step" value="{{ $currentStep }}">
        
        <!-- Step 1: Dati Anagrafici -->
        <div class="wizard-step {{ $currentStep == 1 ? 'block' : 'hidden' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome *</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['name'] ?? old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="surname" class="block text-sm font-medium text-gray-700">Cognome *</label>
                    <input type="text" name="surname" id="surname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['surname'] ?? old('surname') }}" required>
                    @error('surname')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="fiscal_code" class="block text-sm font-medium text-gray-700">Codice Fiscale *</label>
                    <input type="text" name="fiscal_code" id="fiscal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['fiscal_code'] ?? old('fiscal_code') }}" required maxlength="16">
                    @error('fiscal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">Data di Nascita *</label>
                    <input type="date" name="birth_date" id="birth_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['birth_date'] ?? old('birth_date') }}" required>
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Genere *</label>
                    <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Seleziona</option>
                        <option value="M" {{ ($patientData['gender'] ?? old('gender')) == 'M' ? 'selected' : '' }}>Maschile</option>
                        <option value="F" {{ ($patientData['gender'] ?? old('gender')) == 'F' ? 'selected' : '' }}>Femminile</option>
                        <option value="O" {{ ($patientData['gender'] ?? old('gender')) == 'O' ? 'selected' : '' }}>Altro</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="is_pregnant" class="flex items-center">
                        <input type="checkbox" name="is_pregnant" id="is_pregnant" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="1" {{ ($patientData['is_pregnant'] ?? old('is_pregnant')) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Gestante</span>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Step 2: Contatti e Indirizzo -->
        <div class="wizard-step {{ $currentStep == 2 ? 'block' : 'hidden' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['email'] ?? old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefono *</label>
                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['phone'] ?? old('phone') }}" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Indirizzo</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['address'] ?? old('address') }}">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="city" class="block text-sm font-medium text-gray-700">Città</label>
                    <input type="text" name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['city'] ?? old('city') }}">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">CAP</label>
                    <input type="text" name="postal_code" id="postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['postal_code'] ?? old('postal_code') }}">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="province" class="block text-sm font-medium text-gray-700">Provincia</label>
                    <input type="text" name="province" id="province" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['province'] ?? old('province') }}">
                    @error('province')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="country" class="block text-sm font-medium text-gray-700">Paese</label>
                    <input type="text" name="country" id="country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['country'] ?? old('country') ?? 'Italia' }}">
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Step 3: Dati ISEE -->
        <div class="wizard-step {{ $currentStep == 3 ? 'block' : 'hidden' }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="isee_code" class="block text-sm font-medium text-gray-700">Codice ISEE</label>
                    <input type="text" name="isee_code" id="isee_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['isee_code'] ?? old('isee_code') }}">
                    @error('isee_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="isee_value" class="block text-sm font-medium text-gray-700">Valore ISEE</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                        <input type="number" step="0.01" name="isee_value" id="isee_value" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['isee_value'] ?? old('isee_value') }}">
                    </div>
                    @error('isee_value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="isee_expiry_date" class="block text-sm font-medium text-gray-700">Data Scadenza ISEE</label>
                    <input type="date" name="isee_expiry_date" id="isee_expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $patientData['isee_expiry_date'] ?? old('isee_expiry_date') }}">
                    @error('isee_expiry_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Note</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $patientData['notes'] ?? old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Step 4: Conferma Dati -->
        <div class="wizard-step {{ $currentStep == 4 ? 'block' : 'hidden' }}">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Riepilogo Dati</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium text-gray-700">Dati Anagrafici</h4>
                        <dl class="mt-2 space-y-1">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Nome:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['name'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Cognome:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['surname'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Codice Fiscale:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['fiscal_code'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Data di Nascita:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['birth_date'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Genere:</dt>
                                <dd class="text-sm text-gray-900">
                                    @switch($patientData['gender'] ?? '')
                                        @case('M')
                                            Maschile
                                            @break
                                        @case('F')
                                            Femminile
                                            @break
                                        @case('O')
                                            Altro
                                            @break
                                        @default
                                            -
                                    @endswitch
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Gestante:</dt>
                                <dd class="text-sm text-gray-900">{{ ($patientData['is_pregnant'] ?? '') ? 'Sì' : 'No' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-700">Contatti</h4>
                        <dl class="mt-2 space-y-1">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Email:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['email'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Telefono:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['phone'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Indirizzo:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['address'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Città:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['city'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">CAP:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['postal_code'] ?? '' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Provincia:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['province'] ?? '' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="md:col-span-2">
                        <h4 class="font-medium text-gray-700">Dati ISEE</h4>
                        <dl class="mt-2 space-y-1">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Codice ISEE:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['isee_code'] ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Valore ISEE:</dt>
                                <dd class="text-sm text-gray-900">{{ isset($patientData['isee_value']) && $patientData['isee_value'] ? '€ ' . number_format($patientData['isee_value'], 2, ',', '.') : '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Scadenza ISEE:</dt>
                                <dd class="text-sm text-gray-900">{{ $patientData['isee_expiry_date'] ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    @if(isset($patientData['notes']) && !empty($patientData['notes']))
                        <div class="md:col-span-2">
                            <h4 class="font-medium text-gray-700">Note</h4>
                            <p class="mt-2 text-sm text-gray-900">{{ $patientData['notes'] }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="mt-6">
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="privacy_consent" name="privacy_consent" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="privacy_consent" class="font-medium text-gray-700">Consenso al trattamento dei dati</label>
                            <p class="text-gray-500">Confermo di aver letto e accettato l'informativa sulla privacy e acconsento al trattamento dei miei dati personali.</p>
                            @error('privacy_consent')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pulsanti di navigazione -->
        <div class="wizard-navigation flex justify-between mt-8">
            @if($currentStep > 1)
                <button type="button" onclick="prevStep()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Indietro
                </button>
            @else
                <div></div>
            @endif
            
            @if($currentStep < $totalSteps)
                <button type="button" onclick="nextStep()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Avanti
                </button>
            @else
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Completa Registrazione
                </button>
            @endif
        </div>
    </form>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Inizializza la barra di progresso
        updateProgressBar({{ $currentStep }});
    });
    
    function nextStep() {
        // Validazione dello step corrente
        var currentStep = {{ $currentStep }};
        var isValid = true;
        
        // Validazione step 1
        if (currentStep === 1) {
            var requiredFields = ['name', 'surname', 'fiscal_code', 'birth_date', 'gender'];
            for (var i = 0; i < requiredFields.length; i++) {
                var field = requiredFields[i];
                var input = document.getElementById(field);
                if (!input.value) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            }
        }
        
        // Validazione step 2
        if (currentStep === 2) {
            var requiredFields = ['email', 'phone'];
            for (var i = 0; i < requiredFields.length; i++) {
                var field = requiredFields[i];
                var input = document.getElementById(field);
                if (!input.value) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            }
            
            // Validazione email
            var emailInput = document.getElementById('email');
            if (emailInput.value && !isValidEmail(emailInput.value)) {
                emailInput.classList.add('border-red-500');
                isValid = false;
            }
        }
        
        if (isValid) {
            // Aggiorna lo step corrente
            document.querySelector('input[name="current_step"]').value = currentStep + 1;
            
            // Nascondi lo step corrente e mostra il prossimo
            var steps = document.querySelectorAll('.wizard-step');
            for (var i = 0; i < steps.length; i++) {
                steps[i].classList.add('hidden');
            }
            
            steps[currentStep].classList.remove('hidden');
            
            // Aggiorna la barra di progresso
            updateProgressBar(currentStep + 1);
            
            // Salva i dati del form nella sessione
            saveFormData();
        } else {
            alert('Compila tutti i campi obbligatori per procedere.');
        }
    }
    
    function prevStep() {
        var currentStep = {{ $currentStep }};
        
        // Aggiorna lo step corrente
        document.querySelector('input[name="current_step"]').value = currentStep - 1;
        
        // Nascondi lo step corrente e mostra il precedente
        var steps = document.querySelectorAll('.wizard-step');
        for (var i = 0; i < steps.length; i++) {
            steps[i].classList.add('hidden');
        }
        
        steps[currentStep - 2].classList.remove('hidden');
        
        // Aggiorna la barra di progresso
        updateProgressBar(currentStep - 1);
        
        // Salva i dati del form nella sessione
        saveFormData();
    }
    
    function updateProgressBar(step) {
        // Aggiorna visivamente la barra di progresso
        var indicators = document.querySelectorAll('.step-indicator');
        var progressBars = document.querySelectorAll('.wizard-progress .flex-1');
        
        for (var i = 0; i < indicators.length; i++) {
            var indicator = indicators[i];
            var stepNumber = i + 1;
            var circle = indicator.querySelector('div:first-child');
            var text = indicator.querySelector('div:last-child');
            
            if (stepNumber <= step) {
                circle.classList.remove('bg-gray-200', 'text-gray-600');
                circle.classList.add('bg-blue-600', 'text-white');
                text.classList.remove('text-gray-500');
                text.classList.add('text-blue-600', 'font-semibold');
            } else {
                circle.classList.remove('bg-blue-600', 'text-white');
                circle.classList.add('bg-gray-200', 'text-gray-600');
                text.classList.remove('text-blue-600', 'font-semibold');
                text.classList.add('text-gray-500');
            }
        }
        
        for (var j = 0; j < progressBars.length; j++) {
            var bar = progressBars[j];
            if (j < step - 1) {
                bar.classList.remove('bg-gray-200');
                bar.classList.add('bg-blue-600');
            } else {
                bar.classList.remove('bg-blue-600');
                bar.classList.add('bg-gray-200');
            }
        }
    }
    
    function saveFormData() {
        // Salva i dati del form tramite AJAX per mantenere lo stato tra gli step
        var formData = new FormData(document.getElementById('patientRegistrationForm'));
        
        fetch('{{ route("patient.save-draft") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(function(response) {
            return response.json();
        }).then(function(data) {
            if (!data.success) {
                console.error('Errore nel salvataggio dei dati:', data.message);
            }
        }).catch(function(error) {
            console.error('Errore nella richiesta:', error);
        });
    }
    
    function isValidEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
</script>
