<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;  
use App\Models\Projet; // ✔️ import du modèle Message

class ControllerAccueil extends Controller
{
    public function index()
    {
            $projets = Projet::all();  // Récupère tous les projets

        return view('index', compact('projets'));
    }

    public function message(Request $request)
    {   
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // ✔️ Utilisation du bon modèle
        Messages::create($request->all());

        return redirect()->route('index')->with('success', 'Votre message a bien été envoyé.');
    }
}
