<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerAccueil;
use App\Http\Controllers\ControllerCandidature;

  // ✔️ bon nom

Route::get('/', [ControllerAccueil::class, 'index'])
    ->name('index');

Route::get('/rejoindre', function () {
    return view('rejoindre');
})->name('rejoindre');



Route::post('/candidature', [ControllerCandidature::class, 'store'])->name('candidature.store');



// Page admin
Route::get('administrateur', [ControllerAdmin::class, 'index'])
    ->name('admin.projets.index');

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
