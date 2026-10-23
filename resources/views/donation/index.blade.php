@extends('app')
@section('title', 'Faire un don — Verre d’Eau Fraîche')
@section('content')
<section class="bg-gray-50 min-h-screen py-16 px-6">
    <div class="max-w-3xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-xl border border-gray-100">
        <h1 class="text-3xl font-bold text-gray-900">Faire un don</h1>
        <p class="mt-4 text-lg text-gray-600">Votre soutien nous permet de continuer nos actions. Chaque don compte.</p>
        <x-donation-form />
    </div>
</section>
@endsection
