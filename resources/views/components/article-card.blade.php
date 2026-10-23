@props(['article'])<article class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm flex flex-col">
@if($article->image)<img src="{{ asset($article->image) }}" alt="{{ $article->image_alt ?? $article->titre }}" loading="lazy" class="w-full h-52 object-cover">
@endif
<div class="p-6 flex-1 flex flex-col">
<p class="text-sm text-blue-700">{{ $article->published_at?->format('d/m/Y') }} @if($article->category) · {{ $article->category->nom }} @endif
</p>
<h3 class="text-xl font-bold mt-3">{{ $article->titre }}</h3>
<p class="text-gray-600 mt-4 flex-1">{{ $article->extrait }}</p>
<a class="font-semibold text-blue-700 mt-6" href="{{ route('actualites.show',$article->slug) }}">Lire l’article <span class="sr-only">{{ $article->titre }}</span> →</a>
</div>
</article>
