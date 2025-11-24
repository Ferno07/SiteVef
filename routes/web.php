<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerAccueil;
use App\Http\Controllers\ControllerCandidature;


use App\Http\Controllers\ProfileController;


// ------------------------------------------------------
// 1) ROUTES PUBLIQUES DU SITE (PAS BESOIN D'AUTHENTIFICATION)
// ------------------------------------------------------





  // ✔️ bon nom

Route::get('/', [ControllerAccueil::class, 'index'])
    ->name('index');

Route::get('/rejoindre', function () {
    return view('rejoindre');
})->name('rejoindre');



Route::post('/candidature', [ControllerCandidature::class, 'store'])->name('candidature.store');



// Page admin
//Route::get('administrateur', [ControllerAdmin::class, 'index'])
    //->name('admin.projets.index');

// Enregistrement projet
Route::post('/administrateur/enregistrer-projet', [ControllerAdmin::class, 'store'])
    ->name('admin.projets.enregistrer');

// Enregistrement du message du formulaire d’accueil
Route::post('/accueilMessage', [ControllerAccueil::class, 'message'])
    ->name('message');







// Donation Routes
use App\Http\Controllers\DonationController;

Route::get('/don', [DonationController::class, 'index'])->name('donation.index');
Route::post('/don/checkout', [DonationController::class, 'checkout'])->name('donation.checkout');
Route::get('/don/merci', [DonationController::class, 'success'])->name('donation.success');



























// Exemple : page contact
// Route::get('/contact', [SiteController::class, 'contact']);

// Exemple : formulaire contact
// Route::post('/envoyer-message', [SiteController::class, 'envoyer']);

// Mets ici TOUTES tes autres routes publiques



// ------------------------------------------------------
// 2) ROUTES ADMIN (ACCÈS RÉSERVÉ > LOGIN OBLIGATOIRE)
// ------------------------------------------------------
// Redirection après login/register


Route::middleware(['auth', 'verified'])->group(function () {

    // Tableau de bord admin
    Route::get('/administrateur', [ControllerAdmin::class, 'index'])
        ->name('admin.dashboard');

    // Profil (routes Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ------------------------------------------------------
// 3) ROUTES D'AUTHENTIFICATION BREEZE
// ------------------------------------------------------

require __DIR__.'/auth.php';
