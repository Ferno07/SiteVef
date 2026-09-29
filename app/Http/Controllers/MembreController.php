<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membre;
use Illuminate\Support\Facades\Storage;

class MembreController extends Controller
{
    /**
     * Ajouter un nouveau membre.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:100',
            'nom'    => 'required|string|max:100',
            'poste'  => 'required|string|max:150',
            'bio'    => 'nullable|string|max:500',
            'ordre'  => 'nullable|integer|min:0',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $file      = $request->file('photo');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Style1/imagesMembres'), $filename);
            $photoPath = 'Style1/imagesMembres/' . $filename;
        }

        Membre::create([
            'prenom' => $request->prenom,
            'nom'    => $request->nom,
            'poste'  => $request->poste,
            'bio'    => $request->bio,
            'ordre'  => $request->ordre ?? 0,
            'photo'  => $photoPath,
            'actif'  => true,
        ]);

        return redirect()->route('admin.projets.index')
            ->with('success', 'Membre ajouté avec succès !');
    }

    /**
     * Modifier un membre existant.
     */
    public function update(Request $request, int $id)
    {
        $membre = Membre::findOrFail($id);

        $request->validate([
            'prenom' => 'required|string|max:100',
            'nom'    => 'required|string|max:100',
            'poste'  => 'required|string|max:150',
            'bio'    => 'nullable|string|max:500',
            'ordre'  => 'nullable|integer|min:0',
            'photo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Mise à jour de la photo uniquement si une nouvelle est envoyée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo du disque si elle existe
            if ($membre->photo && file_exists(public_path($membre->photo))) {
                unlink(public_path($membre->photo));
            }

            $file      = $request->file('photo');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Style1/imagesMembres'), $filename);
            $membre->photo = 'Style1/imagesMembres/' . $filename;
        }

        $membre->prenom = $request->prenom;
        $membre->nom    = $request->nom;
        $membre->poste  = $request->poste;
        $membre->bio    = $request->bio;
        $membre->ordre  = $request->ordre ?? 0;
        $membre->save();

        return redirect()->route('admin.projets.index')
            ->with('success', 'Membre modifié avec succès !');
    }

    /**
     * Supprimer un membre et sa photo.
     */
    public function destroy(int $id)
    {
        $membre = Membre::findOrFail($id);

        // Supprimer la photo du serveur si elle existe
        if ($membre->photo && file_exists(public_path($membre->photo))) {
            unlink(public_path($membre->photo));
        }

        $membre->delete();

        return redirect()->route('admin.projets.index')
            ->with('success', 'Membre supprimé avec succès !');
    }

    /**
     * Basculer la visibilité publique d'un membre.
     */
    public function toggle(int $id)
    {
        $membre        = Membre::findOrFail($id);
        $membre->actif = !$membre->actif;
        $membre->save();

        return redirect()->route('admin.projets.index')
            ->with('success', 'Visibilité du membre mise à jour.');
    }
}
