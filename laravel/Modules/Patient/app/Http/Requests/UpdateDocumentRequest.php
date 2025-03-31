<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Patient\Entities\Document;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('update', [Document::class, $this->route('patient')]);
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:identity,medical,isee,other',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo del documento è obbligatorio.',
            'title.string' => 'Il titolo deve essere una stringa.',
            'title.max' => 'Il titolo non può superare i 255 caratteri.',
            'type.required' => 'Il tipo di documento è obbligatorio.',
            'type.string' => 'Il tipo deve essere una stringa.',
            'type.in' => 'Il tipo di documento non è valido.',
            'file.file' => 'Il file caricato non è valido.',
            'file.mimes' => 'Il file deve essere in formato PDF, JPG, JPEG o PNG.',
            'file.max' => 'Il file non può superare i 10MB.',
            'expiry_date.date' => 'La data di scadenza non è valida.',
            'expiry_date.after' => 'La data di scadenza deve essere futura.',
            'notes.string' => 'Le note devono essere una stringa.',
            'notes.max' => 'Le note non possono superare i 1000 caratteri.',
        ];
    }
} 