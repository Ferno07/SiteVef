<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\candidature;

class ControllerCandidature extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'dateNaissance' => 'required|date',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'typeParticipation' => 'required|string|max:255',
            'autreType' => 'nullable|string|max:255',
            'disponibilites' => 'required|string',
            'preferenceAction' => 'required|string|max:255',
            'motivation' => 'required|string',
            'rgpd' => 'accepted', // ✅ changé de boolean à accepted
        ]);

        $data = [
            'candidature_nom' => $request->nom,
            'candidature_prenom' => $request->prenom,
            'candidature_dateNaissance' => $request->dateNaissance,
            'candidature_email' => $request->email,
            'candidature_telephone' => $request->telephone,
            'candidature_adresse' => $request->adresse,
            'candidature_typeParticipation' => $request->typeParticipation,
            'candidature_autreType' => $request->typeParticipation === 'autre' ? $request->autreType : null,
            'candidature_disponibilites' => $request->disponibilites,
            'candidature_preferenceAction' => $request->preferenceAction,
            'candidature_motivation' => $request->motivation,
            'candidature_rgpd' => $request->has('rgpd') ? true : false,
        ];

        // Debug si rien n'est enregistré
         //dd($data);

        Candidature::create($data);

        return redirect()->back()->with('success', 'Votre candidature a bien été envoyée !');
    }
}
