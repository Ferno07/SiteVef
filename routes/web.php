<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerAccueil;
use App\Http\Controllers\ControllerCandidature;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;

Route::get('/test-route', function () {
    return 'OK';
});

  // ✔️ bon nom

Route::get('/', [ControllerAccueil::class, 'index'])
    ->name('index');

Route::get('/rejoindre', function () {
    return view('rejoindre');
})->name('rejoindre');


// Route pour supprimer les projets dans la base
Route::resource('posts', PostController::class);


Route::post('/candidature', [ControllerCandidature::class, 'store'])->name('candidature.store');



// Page admin


// Enregistrement du message du formulaire d’accueil


 Route::post('/accueilMessage', [ControllerAccueil::class, 'message'])
    ->name('message');




// Donation Routes


Route::get('/don', [DonationController::class, 'index'])->name('donation.index');
Route::post('/don/checkout', [DonationController::class, 'checkout'])->name('donation.checkout');
Route::get('/don/merci', [DonationController::class, 'success'])->name('donation.success');

// Exemple : page contact
// Route::get('/contact', [SiteController::class, 'contact']);

// Exemple : formulaire contact
// Route::post('/envoyer-message', [SiteController::class, 'envoyer']);

// Mets ici TOUTES tes autres routes publiques




















Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/administrateur', [AdminController::class, 'index'])
    ->name('admin.projets.index');

   

    // Enregistrement projet
Route::post('/administrateur/enregistrer-projet', [AdminController::class, 'store'])
    ->name('admin.projets.enregistrer');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
