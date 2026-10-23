@props(['projet'])
<article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition-shadow">
@if($projet->image)<a href="{{ route('projets.show',$projet->slug) }}" tabindex="-1" aria-hidden="true">
<img src="{{ asset($projet->image) }}" alt="" loading="lazy" class="w-full h-52 object-cover">
</a>
@endif
<div class="p-6 flex flex-col flex-1">
<x-project-status :status="$projet->statut" />
<h3 class="mt-3 text-xl font-bold text-gray-900">{{ $projet->titre }}</h3>
@if($projet->localisation)<p class="text-sm text-gray-500 mt-2">{{ $projet->localisation }}</p>
@endif
<p class="text-gray-600 mt-4 flex-1">{{ $projet->description }}</p>
<a href="{{ route('projets.show',$projet->slug) }}" class="mt-6 inline-flex font-semibold text-blue-700 rounded focus-visible:ring-2 focus-visible:ring-blue-600">Découvrir le projet <span class="sr-only">{{ $projet->titre }}</span> →</a>
</div>
</article>
