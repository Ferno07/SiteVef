<?php

// app/Http/Controllers/ProjetController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Messages;


class AdminController extends Controller


{

    public function index()
        {
            $projets = Projet::all();
            $messages= Messages::all();

            return view('admin.admin', compact('projets','messages'));
        }



    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_longue' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $projet = new Projet();
        $projet->titre = $request->titre;
        $projet->description = $request->description;
        $projet->description_longue = $request->description_longue;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Déplacement vers public/Style1/imagesProjets
                $file->move(public_path('Style1/imagesProjets'), $filename);

                $projet->image = 'Style1/imagesProjets/' . $filename;
            }


        $projet->save();
        

        return redirect()->route('admin.projets.index');

    }
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id); // récupère le projet ou renvoie 404
        $projet->delete(); // supprime le projet

        return redirect()->back()->with('success', 'Projet supprimé avec succès !');
    }


        public function toggleRead($id)
    {
        $message = Message::findOrFail($id);
        $message->lu = !$message->lu; // inverse l'état
        $message->save();

        return response()->json([
            'success' => true,
            'lu' => $message->lu
        ]);
    }
}