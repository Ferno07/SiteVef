<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:grant {email}', function () {
    $user = \App\Models\User::where('email', $this->argument('email'))->firstOrFail();
    $user->forceFill(['is_admin' => true])->save();
    $this->info('Accès administrateur attribué.');
})->purpose('Attribuer explicitement le rôle administrateur à un compte existant');
