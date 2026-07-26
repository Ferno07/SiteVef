<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Messages;
use App\Models\Candidature;
use App\Models\Temoignage;
use App\Models\Visite;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $projets      = Projet::all();
        $messages     = Messages::orderBy('created_at', 'desc')->get();
        $candidatures = Candidature::orderBy('created_at', 'desc')->get();
        $temoignages  = Temoignage::orderBy('created_at', 'desc')->get();

        // Statistiques visiteurs
        $today         = Carbon::today();
        $debutMois     = Carbon::now()->startOfMonth();
        $debutMoisPrec = Carbon::now()->subMonth()->startOfMonth();
        $finMoisPrec   = Carbon::now()->subMonth()->endOfMonth();

        $visiteursAujourdhui = Visite::whereDate('date', $today)->count();
        $visiteursMoisActuel = Visite::whereBetween('date', [$debutMois, Carbon::now()])->count();
        $visiteursMoisPrec   = Visite::whereBetween('date', [$debutMoisPrec, $finMoisPrec])->count();

        $evolutionVisiteurs = $visiteursMoisPrec > 0
            ? round((($visiteursMoisActuel - $visiteursMoisPrec) / $visiteursMoisPrec) * 100, 1)
            : ($visiteursMoisActuel > 0 ? 100 : 0);

        // Données pour le graphique — 12 derniers mois
        $graphLabels  = [];
        $graphDonnees = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois           = Carbon::now()->subMonths($i);
            $debut          = $mois->copy()->startOfMonth();
            $fin            = $mois->copy()->endOfMonth();
            $graphLabels[]  = $mois->isoFormat('MMM YYYY');
            $graphDonnees[] = Visite::whereBetween('date', [$debut, $fin])->count();
        }

        $stats = [
            'projets'             => $projets->count(),
            'messages'            => $messages->count(),
            'messages_non_lus'    => $messages->where('lu', false)->count(),
            'candidatures'        => $candidatures->count(),
            'temoignages'         => $temoignages->count(),
            'visiteurs_jour'      => $visiteursAujourdhui,
            'visiteurs_mois'      => $visiteursMoisActuel,
            'visiteurs_mois_prec' => $visiteursMoisPrec,
            'evolution_visiteurs' => $evolutionVisiteurs,
        ];

        return view('admin.admin', compact('projets', 'messages', 'candidatures', 'temoignages', 'stats', 'graphLabels', 'graphDonnees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'description_longue'=> 'nullable|string',
            'image'             => 'nullable|image|max:2048',
        ]);

        $projet = new Projet();
        $projet->titre             = $request->titre;
        $projet->description       = $request->description;
        $projet->description_longue = $request->description_longue;

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Style1/imagesProjets'), $filename);
            $projet->image = 'Style1/imagesProjets/' . $filename;
        }

        $projet->save();

        return redirect()->route('admin.projets.index')->with('success', 'Projet ajouté avec succès !');
    }

    public function destroy(int $id)
    {
        $projet = Projet::findOrFail($id);
        $projet->delete();

        return redirect()->back()->with('success', 'Projet supprimé avec succès !');
    }

    public function toggleRead(int $id)
    {
        $message = Messages::findOrFail($id);
        $message->lu = !$message->lu;
        $message->save();

        return response()->json([
            'success' => true,
            'lu'      => $message->lu,
        ]);
    }
}
