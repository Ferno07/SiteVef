<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Messages;
use App\Models\Projet;
use App\Models\Temoignage;
use App\Mail\NouveauMessage;

class ControllerAccueil extends Controller
{
    public function index()
    {
        $projets     = Projet::all();
        $temoignages = Temoignage::where('actif', true)->orderBy('created_at', 'desc')->get();

        return view('index', compact('projets', 'temoignages'));
    }

    public function message(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:255',
            'prenom'  => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'objet'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactMessage = Messages::create([
            'nom'     => $request->nom,
            'prenom'  => $request->prenom,
            'email'   => $request->email,
            'objet'   => $request->objet,
            'message' => $request->message,
            'lu'      => false,
        ]);

        Mail::to('fernandtovignonnou@gmail.com')->send(new NouveauMessage($contactMessage));

        return redirect()->route('index')->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }
}
