<?php

namespace App\Http\Requests;

use App\Models\ProgrammeParrainage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProgrammeParrainageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('admin') ?? false;
    }

    public function rules(): array
    {
        $isChildProgramme = $this->route('programme')->code === ProgrammeParrainage::ENFANT;
        $imageRequired = $this->hasFile('image')
            || ($this->route('programme')->image && ! $this->boolean('retirer_image'));

        return [
            'titre' => ['required', 'string', 'max:150'],
            'accroche' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'montant_mensuel' => $isChildProgramme
                ? ['required', 'numeric', 'decimal:0,2', 'min:1', 'max:100000']
                : ['prohibited'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'image_alt' => [$imageRequired ? 'required' : 'nullable', 'string', 'max:255'],
            'retirer_image' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'titre' => 'titre du programme',
            'accroche' => 'accroche',
            'description' => 'description',
            'montant_mensuel' => 'montant mensuel en euros',
            'image_alt' => 'description de la photo',
        ];
    }
}
