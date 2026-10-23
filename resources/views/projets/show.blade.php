@extends('app')
@section('title', $projet->seo_title ?: $projet->titre.' — VEF')
@section('meta_description', $projet->meta_description ?: ($projet->description ?: $projet->titre))
@section('og_image', $projet->image ? asset($projet->image) : asset('Style1/images/better.jpg'))
@push('head')@if($preview)<meta name="robots" content="noindex,nofollow">
@endif @endpush
@section('content')
@php($collected=$projet->collected)
<section class="bg-white">
<div class="max-w-7xl mx-auto px-6 py-16">
@if($preview)<p class="bg-blue-50 text-blue-800 p-4 rounded-xl mb-8">Aperçu administrateur · {{ $projet->publication }} · Les dons sont désactivés dans cet aperçu.</p>
@endif
<a href="{{ route('projets.index') }}" class="text-blue-700 font-semibold">← Tous les projets</a>
<div class="grid lg:grid-cols-2 gap-12 items-center mt-10">
<div>
<x-project-status :status="$projet->statut" />
@if($projet->localisation)<p class="mt-4 text-gray-500">{{ $projet->localisation }}</p>
@endif
<h1 class="text-4xl lg:text-5xl font-bold mt-5 leading-tight">{{ $projet->titre }}</h1>
@if($projet->description)<p class="mt-6 text-xl text-gray-600 leading-8">{{ $projet->description }}</p>
@endif @if($projet->dons_actifs && !$preview)<a href="#don" class="inline-block bg-blue-600 hover:bg-blue-500 text-white rounded-full px-8 py-4 font-bold mt-8">Soutenir ce projet</a>
@endif
</div>
@if($projet->image)<img src="{{ asset($projet->image) }}" alt="{{ $projet->titre }}" class="rounded-2xl w-full max-h-[520px] object-cover shadow-lg">
@endif
</div>
</div>
</section>
<div class="max-w-5xl mx-auto px-6 py-16 space-y-12">
@foreach(['description_longue'=>'Le projet','contexte'=>'Pourquoi ce projet ?','solution'=>'Notre réponse','objectifs'=>'Nos objectifs','beneficiaires'=>'Les bénéficiaires'] as $field=>$label)@if($projet->$field)<section>
<h2 class="text-2xl font-bold mb-5">{{ $label }}</h2>
<p class="whitespace-pre-line text-gray-600 leading-8">{{ $projet->$field }}</p>
</section>
@endif @endforeach

@if($projet->indicateurs)<section class="grid sm:grid-cols-3 gap-6">
@foreach($projet->indicateurs as $row)<div class="rounded-2xl bg-blue-50 p-8">
<p class="text-3xl font-bold text-blue-700">{{ $row[1] }}</p>
<p class="mt-3 text-gray-600">{{ $row[0] }}</p>
</div>
@endforeach
</section>
@endif
@if($projet->etapes)<section>
<h2 class="text-2xl font-bold mb-8">Comment le projet sera réalisé</h2>
<ol class="border-l-2 border-blue-100 space-y-8 ml-4">
@foreach($projet->etapes as $step)<li class="pl-8 relative">
<span class="absolute -left-4 rounded-full bg-blue-600 text-white w-8 h-8 flex items-center justify-center">{{ $loop->iteration }}</span>
<h3 class="font-bold text-lg">{{ $step[0] }}</h3>
@if(!empty($step[1]))<p class="text-gray-600 mt-2 whitespace-pre-line">{{ $step[1] }}</p>
@endif
</li>
@endforeach
</ol>
</section>
@endif
@if($projet->budget_centimes !== null || $projet->depenses || $projet->financement_note)<section class="bg-white p-8 rounded-2xl border border-gray-100">
<h2 class="text-2xl font-bold">Budget et financement</h2>
@if($projet->budget_centimes !== null)<p class="mt-6 text-gray-600">Budget prévisionnel <strong class="block text-3xl text-blue-700 mt-2">{{ number_format($projet->budget_centimes/100,2,',',' ') }} €<span class="block text-base font-medium mt-2">≈ {{ \App\Services\Money::fcfa($projet->budget_centimes/100) }}</span></strong>
</p>
@endif
@if($projet->depenses)<table class="w-full mt-8">
<caption class="text-left font-semibold mb-3">Répartition prévisionnelle</caption>
<thead>
<tr>
<th class="text-left py-3">Poste</th>
<th class="text-right py-3">Montant</th>
</tr>
</thead>
<tbody>
@foreach($projet->depenses as $row)<tr class="border-t border-gray-100">
<td class="py-3">{{ $row[0] }}</td>
<td class="text-right">{{ number_format((float)$row[1],2,',',' ') }} €<span class="block text-sm text-gray-500">≈ {{ \App\Services\Money::fcfa((float)$row[1]) }}</span></td>
</tr>
@endforeach
</tbody>
</table>
@endif
@if($projet->dons_actifs || $collected>0)<div class="mt-8">
<p>
<strong>{{ number_format($collected/100,2,',',' ') }} € (≈ {{ \App\Services\Money::fcfa($collected/100) }})</strong> de dons confirmés</p>
@if($projet->budget_centimes>0)<progress class="w-full mt-4 h-3" max="{{ $projet->budget_centimes }}" value="{{ min($collected,$projet->budget_centimes) }}" aria-label="Progression du financement">
</progress>
<p class="text-sm text-gray-500 mt-3">{{ round($collected/$projet->budget_centimes*100) }} % de l’objectif · {{ number_format(max(0,$projet->budget_centimes-$collected)/100,2,',',' ') }} € (≈ {{ \App\Services\Money::fcfa(max(0,$projet->budget_centimes-$collected)/100) }}) restant à collecter</p>
@endif
<p class="text-sm text-gray-500 mt-3">Ces montants reposent uniquement sur les paiements confirmés par le prestataire.</p>
</div>
@endif
@if($projet->financement_note)<p class="mt-6 whitespace-pre-line text-gray-600">{{ $projet->financement_note }}</p>
@endif
<p class="mt-6 text-sm text-gray-500">Informations du projet mises à jour le {{ $projet->updated_at->format('d/m/Y') }}.</p>
</section>
@endif
<section class="bg-blue-50 rounded-2xl p-8">
<h2 class="text-2xl font-bold">Qui porte ce projet ?</h2>
<p class="text-gray-600 mt-5">L’association humanitaire Verre d’Eau Fraîche agit pour l’éducation, la santé et l’autonomisation des personnes vulnérables.</p>
@if($projet->equipe)<p class="mt-5 whitespace-pre-line text-gray-600">{{ $projet->equipe }}</p>
@endif
<a href="{{ route('equipe') }}" class="inline-block text-blue-700 font-semibold mt-5">Découvrir notre équipe →</a>
</section>

@if($projet->dons_actifs && !$preview)
<section class="rounded-2xl bg-blue-50 border border-blue-100 p-8 text-center" aria-labelledby="soutenir-titre">
    <h2 id="soutenir-titre" class="text-2xl font-bold text-gray-900">Vous souhaitez contribuer à ce projet ?</h2>
    <p class="mt-4 text-gray-600">Après avoir découvert ses objectifs et son financement, vous pouvez soutenir cette action par un don.</p>
    <a href="#don" class="inline-block mt-6 bg-blue-600 hover:bg-blue-500 text-white rounded-full px-8 py-4 font-bold">Faire un don pour ce projet</a>
</section>
@endif
@if($projet->dons_actifs && !$preview)<section id="don" class="scroll-mt-28 bg-white rounded-2xl p-8 border border-blue-100 shadow-sm">
<h2 class="text-3xl font-bold">Ensemble, soutenons ce projet</h2>
<p class="mt-4 text-gray-600">Chaque contribution aide l’association à mobiliser les ressources nécessaires à cette action.</p>
<x-donation-form :projet="$projet" :amounts="$projet->montants_suggeres ?? []" />
</section>
@endif
@if($articles->isNotEmpty())<section>
<h2 class="text-2xl font-bold mb-8">Actualités et suivi du projet</h2>
<div class="grid sm:grid-cols-2 gap-6">
@foreach($articles as $article)<x-article-card :article="$article"/>
@endforeach
</div>
</section>
@endif
@if(count($projet->galerie))<section>
<h2 class="text-2xl font-bold mb-8">Le projet en images</h2>
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
@foreach($projet->galerie as $image)<a href="{{ $image }}" target="_blank" rel="noopener" class="rounded-xl overflow-hidden focus-visible:ring-2 focus-visible:ring-blue-600">
<img src="{{ $image }}" alt="{{ $projet->titre }} — photo {{ $loop->iteration }} (ouvrir en grand)" loading="lazy" class="w-full h-48 object-cover">
</a>
@endforeach
</div>
</section>
@endif
@if($projet->faq)<section>
<h2 class="text-2xl font-bold mb-6">Questions fréquentes</h2>
@foreach($projet->faq as $row)<details class="border-b border-gray-200 py-5">
<summary class="font-semibold cursor-pointer text-gray-900">{{ $row[0] }}</summary>
<p class="mt-4 text-gray-600 whitespace-pre-line">{{ $row[1] }}</p>
</details>
@endforeach
</section>
@endif
<section class="bg-blue-900 text-white rounded-2xl p-8 text-center">
<h2 class="text-2xl font-bold">Agissons ensemble</h2>
<p class="mt-4 text-blue-100">Faites connaître cette initiative et découvrez les autres actions de l’association.</p>
<div class="flex flex-wrap justify-center gap-4 mt-8">
@if($projet->dons_actifs && !$preview)<a href="#don" class="bg-blue-600 rounded-full px-6 py-3 font-semibold">Faire un don pour ce projet</a>
@endif

<a class="border border-white/50 rounded-full px-6 py-3" href="{{ route('projets.index') }}">Nos autres projets</a>
</div>
@if(!$preview)
<x-project-share :url="route('projets.show', $projet->slug)" />
@endif
</section>
</div>
@endsection
