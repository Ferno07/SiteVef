@extends('app')
@section('title', 'Nos projets humanitaires — Verre d’Eau Fraîche')
@section('content')
<section class="bg-white py-16">
<div class="max-w-7xl mx-auto px-6">
<p class="font-semibold text-blue-700">AGIR ENSEMBLE</p>
<h1 class="text-4xl font-bold mt-3">Nos projets humanitaires</h1>
<p class="mt-6 text-lg text-gray-600 max-w-3xl">Découvrez les initiatives de l’association, leurs objectifs et les actions menées auprès des personnes vulnérables.</p>
</div>
</section>
<section class="max-w-7xl mx-auto px-6 py-12">
<nav class="flex flex-wrap gap-3 mb-10" aria-label="Filtrer les projets">
@foreach([''=>'Tous les projets','en_cours'=>'En cours','a_venir'=>'À venir','realise'=>'Réalisés'] as $value=>$label)
<a href="{{ route('projets.index', $value ? ['statut'=>$value] : []) }}"
   @if(request('statut','')===$value) aria-current="page" @endif
   class="project-status project-status-filter project-status--{{ $value ?: 'a_venir' }}">
    @if($value)<span class="project-status__marker" aria-hidden="true">{{ $value === 'realise' ? '✓' : '' }}</span>@endif
    {{ $label }}
</a>
@endforeach
</nav>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
@forelse($projets as $projet)<x-project-card :projet="$projet"/>
@empty<p class="text-gray-600">Aucun projet dans cette rubrique pour le moment.</p>
@endforelse
</div>
<div class="mt-10">{{ $projets->links() }}</div>
</section>
@endsection
