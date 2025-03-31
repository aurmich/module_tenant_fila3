<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \Modules\Patient\Entities\Patient::class);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'fiscal_code' => ['required', 'string', 'max:16', 'unique:patients,fiscal_code'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:M,F,O'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:2'],
            'postal_code' => ['nullable', 'string', 'max:5'],
            'isee_value' => ['nullable', 'numeric', 'min:0'],
            'isee_expiry_date' => ['nullable', 'date', 'after:today'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Il nome è obbligatorio.',
            'last_name.required' => 'Il cognome è obbligatorio.',
            'fiscal_code.required' => 'Il codice fiscale è obbligatorio.',
            'fiscal_code.unique' => 'Questo codice fiscale è già registrato.',
            'birth_date.required' => 'La data di nascita è obbligatoria.',
            'gender.required' => 'Il genere è obbligatorio.',
            'gender.in' => 'Il genere deve essere M, F o O.',
            'email.email' => 'L\'indirizzo email non è valido.',
            'province.max' => 'La provincia deve essere di 2 caratteri.',
            'postal_code.max' => 'Il CAP deve essere di 5 caratteri.',
            'isee_value.numeric' => 'Il valore ISEE deve essere numerico.',
            'isee_value.min' => 'Il valore ISEE non può essere negativo.',
            'isee_expiry_date.after' => 'La data di scadenza ISEE deve essere futura.',
        ];
    }
} 