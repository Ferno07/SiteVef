<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Messages;
use App\Models\Candidature;
use App\Models\Temoignage;
use App\Models\Visite;
use App\Models\Membre;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $projets      = Projet::with('images')->get();

        // Migration douce : les projets créés avant la galerie multi-photos
        // n'ont qu'une image (colonne `image`) sans ligne dans `projet_images`.
        $projets->each(function (Projet $projet) {
            if ($projet->images->isEmpty() && $projet->image) {
                $projet->images()->create(['chemin' => $projet->image, 'ordre' => 0]);
                $projet->load('images');
            }
        });
        $messages     = Messages::orderBy('created_at', 'desc')->get();
        $candidatures = Candidature::orderBy('created_at', 'desc')->get();
        $temoignages  = Temoignage::orderBy('created_at', 'desc')->get();
        $membres      = Membre::orderBy('ordre')->orderBy('created_at')->get();

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
            'membres'             => $membres->count(),
            'visiteurs_jour'      => $visiteursAujourdhui,
            'visiteurs_mois'      => $visiteursMoisActuel,
            'visiteurs_mois_prec' => $visiteursMoisPrec,
            'evolution_visiteurs' => $evolutionVisiteurs,
        ];

        return view('admin.admin', compact('projets', 'messages', 'candidatures', 'temoignages', 'membres', 'stats', 'graphLabels', 'graphDonnees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'description_longue'=> 'nullable|string',
            'images'            => 'nullable|array',
            'images.*'          => 'image|max:2048',
        ]);

        $projet = new Projet();
        $projet->titre             = $request->titre;
        $projet->description       = $request->description;
        $projet->description_longue = $request->description_longue;

        $chemins = [];
        foreach ($request->file('images', []) as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Style1/imagesProjets'), $filename);
            $chemins[] = 'Style1/imagesProjets/' . $filename;
        }

        if (!empty($chemins)) {
            $projet->image = $chemins[0];
        }

        $projet->save();

        foreach ($chemins as $ordre => $chemin) {
            $projet->images()->create([
                'chemin' => $chemin,
                'ordre'  => $ordre,
            ]);
        }

        return redirect()->route('admin.projets.index')->with('success', 'Projet ajouté avec succès !');
    }

    public function update(Request $request, int $id)
    {
        $projet = Projet::with('images')->findOrFail($id);

        $request->validate([
            'titre'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'description_longue'  => 'nullable|string',
            'images'              => 'nullable|array',
            'images.*'            => 'image|max:2048',
            'supprimer_images'    => 'nullable|array',
            'supprimer_images.*'  => 'integer|exists:projet_images,id',
        ]);

        $projet->titre              = $request->titre;
        $projet->description        = $request->description;
        $projet->description_longue = $request->description_longue;

        // Retirer les photos décochées
        foreach ($request->input('supprimer_images', []) as $imageId) {
            $image = $projet->images->firstWhere('id', $imageId);
            if ($image) {
                if (file_exists(public_path($image->chemin))) {
                    unlink(public_path($image->chemin));
                }
                $image->delete();
            }
        }

        // Ajouter les nouvelles photos
        $ordre = (int) $projet->images()->max('ordre');
        foreach ($request->file('images', []) as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('Style1/imagesProjets'), $filename);
            $ordre++;
            $projet->images()->create([
                'chemin' => 'Style1/imagesProjets/' . $filename,
                'ordre'  => $ordre,
            ]);
        }

        // La couverture (utilisée sur la carte projet) suit la première photo de la galerie
        $projet->image = optional($projet->images()->orderBy('ordre')->first())->chemin;
        $projet->save();

        return redirect()->route('admin.projets.index')->with('success', 'Projet modifié avec succès !');
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
