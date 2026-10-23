<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EditorialData
{
    public static function project(Request $r, $project = null): array
    {
        $data = $r->validate([
            'titre' => 'required|string|max:255', 'description' => 'nullable|string|max:255', 'description_longue' => 'nullable|string|max:50000',
            'slug' => ['nullable', 'alpha_dash', 'max:220', Rule::unique('projets')->ignore($project?->id)],
            'publication' => ['required', Rule::in(['brouillon', 'publie', 'archive'])], 'statut' => ['required', Rule::in(['a_venir', 'en_cours', 'realise'])],
            'localisation' => 'nullable|string|max:255', 'budget' => 'nullable|numeric|min:0|max:100000000', 'dons_actifs' => 'nullable|boolean',
            'seo_title' => 'nullable|string|max:255', 'meta_description' => 'nullable|string|max:255',
            'contexte' => 'nullable|string|max:30000', 'solution' => 'nullable|string|max:30000', 'objectifs' => 'nullable|string|max:30000', 'beneficiaires' => 'nullable|string|max:30000', 'equipe' => 'nullable|string|max:30000', 'financement_note' => 'nullable|string|max:30000',
            'indicateurs_texte' => 'nullable|string|max:10000', 'etapes_texte' => 'nullable|string|max:10000', 'depenses_texte' => 'nullable|string|max:10000', 'faq_texte' => 'nullable|string|max:20000', 'montants_texte' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:20', 'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:3072',
            'supprimer_images' => 'nullable|array', 'supprimer_images.*' => 'integer', 'couverture_id' => 'nullable|integer',
        ]);
        $data['slug'] = $data['slug'] ?? $project?->slug ?? ((Str::slug($data['titre']) ?: 'projet').'-'.Str::lower(Str::random(6)));
        $data['dons_actifs'] = $r->boolean('dons_actifs');
        $data['budget_centimes'] = filled($r->budget) ? (int) round((float) $r->budget * 100) : null;
        foreach (['indicateurs', 'etapes', 'depenses', 'faq'] as $field) {
            $data[$field] = [];
            foreach (preg_split('/\R/u', $r->input($field.'_texte', '') ?? '') as $line) {
                if (! trim($line)) {
                    continue;
                }
                $parts = array_map('trim', explode('|', $line, 2));
                if ($field !== 'etapes' && (count($parts) !== 2 || ! $parts[0] || ! $parts[1])) {
                    throw \Illuminate\Validation\ValidationException::withMessages([$field.'_texte' => 'Chaque ligne doit contenir deux valeurs séparées par |.']);
                }
                if ($field === 'depenses' && (! is_numeric($parts[1]) || (float) $parts[1] < 0)) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['depenses_texte' => 'Le montant de chaque dépense doit être positif.']);
                }
                $data[$field][] = $parts;
            }
        }
        $data['montants_suggeres'] = [];
        foreach (explode(',', $r->input('montants_texte', '') ?? '') as $amount) {
            if (! trim($amount)) {
                continue;
            }
            if (! is_numeric(trim($amount)) || (float) $amount < 1 || (float) $amount > 100000) {
                throw \Illuminate\Validation\ValidationException::withMessages(['montants_texte' => 'Indiquez des montants entre 1 et 100 000 €, séparés par des virgules.']);
            }
            $data['montants_suggeres'][] = (float) $amount;
        }
        foreach (['budget', 'images', 'supprimer_images', 'couverture_id', 'indicateurs_texte', 'etapes_texte', 'depenses_texte', 'faq_texte', 'montants_texte'] as $f) {
            unset($data[$f]);
        }

        return $data;
    }

    public static function upload($file, string $folder): string
    {
        $name = Str::uuid().'.'.$file->extension();
        $file->move(public_path('Style1/'.$folder), $name);

        return 'Style1/'.$folder.'/'.$name;
    }
}
