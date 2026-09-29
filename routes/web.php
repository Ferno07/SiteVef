<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAccueil;
use App\Http\Controllers\ControllerCandidature;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TemoignageController;
use App\Http\Controllers\MembreController;

// ── Routes publiques ──────────────────────────────────────────────────────────

Route::get('/', [ControllerAccueil::class, 'index'])->name('index');

Route::get('/rejoindre', fn () => view('rejoindre'))->name('rejoindre');

Route::get('/equipe', [ControllerAccueil::class, 'equipe'])->name('equipe');

Route::post('/candidature', [ControllerCandidature::class, 'store'])->name('candidature.store');

Route::post('/accueilMessage', [ControllerAccueil::class, 'message'])->name('message');

// Donations (Stripe)
Route::get('/don', [DonationController::class, 'index'])->name('donation.index');
Route::post('/don/checkout', [DonationController::class, 'checkout'])->name('donation.checkout');
Route::get('/don/merci', [DonationController::class, 'success'])->name('donation.success');

// Suppression projet (resource, seul destroy est utilisé)
Route::resource('posts', PostController::class);

// ── Routes authentifiées ──────────────────────────────────────────────────────

Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Admin dashboard
    Route::get('/administrateur', [AdminController::class, 'index'])
        ->name('admin.projets.index');

    // Projets
    Route::post('/administrateur/enregistrer-projet', [AdminController::class, 'store'])
        ->name('admin.projets.enregistrer');

    Route::put('/administrateur/projet/{id}', [AdminController::class, 'update'])
        ->name('admin.projets.update');

    Route::delete('/administrateur/projet/{id}', [AdminController::class, 'destroy'])
        ->name('admin.projets.destroy');

    // Messages — marquer lu / non lu
    Route::post('/administrateur/messages/{id}/toggle-read', [AdminController::class, 'toggleRead'])
        ->name('admin.messages.toggleRead');

    // Témoignages
    Route::post('/administrateur/temoignages', [TemoignageController::class, 'store'])
        ->name('admin.temoignages.store');

    Route::delete('/administrateur/temoignages/{id}', [TemoignageController::class, 'destroy'])
        ->name('admin.temoignages.destroy');

    Route::post('/administrateur/temoignages/{id}/toggle', [TemoignageController::class, 'toggle'])
        ->name('admin.temoignages.toggle');

    // Membres
    Route::post('/administrateur/membres', [MembreController::class, 'store'])
        ->name('admin.membres.store');

    Route::put('/administrateur/membres/{id}', [MembreController::class, 'update'])
        ->name('admin.membres.update');

    Route::delete('/administrateur/membres/{id}', [MembreController::class, 'destroy'])
        ->name('admin.membres.destroy');

    Route::post('/administrateur/membres/{id}/toggle', [MembreController::class, 'toggle'])
        ->name('admin.membres.toggle');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
