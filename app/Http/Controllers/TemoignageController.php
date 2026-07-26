<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Temoignage;

class TemoignageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'auteur' => 'required|string|max:255',
            'role'   => 'nullable|string|max:255',
            'texte'  => 'required|string',
        ]);

        Temoignage::create([
            'auteur' => $request->auteur,
            'role'   => $request->role,
            'texte'  => $request->texte,
            'actif'  => true,
        ]);

        return redirect()->route('admin.projets.index')->with('success', 'Témoignage ajouté avec succès !');
    }

    public function destroy(int $id)
    {
        $temoignage = Temoignage::findOrFail($id);
        $temoignage->delete();

        return redirect()->route('admin.projets.index')->with('success', 'Témoignage supprimé avec succès !');
    }

    public function toggle(int $id)
    {
        $temoignage = Temoignage::findOrFail($id);
        $temoignage->actif = !$temoignage->actif;
        $temoignage->save();

        return redirect()->route('admin.projets.index')->with('success', 'Statut du témoignage mis à jour.');
    }
}
