@extends('app')
@section('title', $article->seo_title ?: $article->titre.' — VEF')
@section('meta_description', $article->meta_description ?: ($article->extrait ?: $article->titre))
@section('og_image', $article->image ? asset($article->image) : asset('Style1/images/better.jpg'))
@push('head')@if($preview)<meta name="robots" content="noindex,nofollow">
@endif @endpush
@section('content')<article class="max-w-4xl mx-auto px-6 py-16">
@if($preview)<p class="rounded-xl bg-blue-50 p-4 text-blue-800 mb-8">Aperçu administrateur · {{ $article->publication }}</p>
@endif
<a href="{{ route('actualites.index') }}" class="text-blue-700">← Toutes les actualités</a>
<p class="mt-8 text-gray-500">{{ $article->published_at?->format('d/m/Y') }} @if($article->category) · {{ $article->category->nom }} @endif
</p>
<h1 class="mt-4 text-4xl font-bold">{{ $article->titre }}</h1>
@if($article->extrait)<p class="mt-6 text-xl text-gray-600">{{ $article->extrait }}</p>
@endif @if($article->image)<img src="{{ asset($article->image) }}" alt="{{ $article->image_alt ?: $article->titre }}" class="rounded-2xl w-full mt-10">
@endif
<div class="mt-10 space-y-6 text-gray-700 leading-8">
@foreach(preg_split('/\R/u',$article->contenu) as $line)@if(str_starts_with($line,'### '))<h3 class="text-xl font-bold text-gray-900">{{ substr($line,4) }}</h3>
@elseif(str_starts_with($line,'## '))<h2 class="text-2xl font-bold text-gray-900">{{ substr($line,3) }}</h2>
@elseif(trim($line))<p>{!! \App\Services\ArticleText::line($line) !!}</p>
@endif @endforeach
</div>
@if($article->projets->isNotEmpty())<section class="mt-12 p-8 bg-blue-50 rounded-2xl">
<h2 class="text-2xl font-bold">Les projets associés</h2>
@foreach($article->projets as $project)<a class="block mt-4 text-blue-700 font-semibold" href="{{ route('projets.show',$project->slug) }}">{{ $project->titre }} →</a>
@endforeach
</section>
@endif
<a class="inline-block mt-8 text-blue-700" href="mailto:?subject={{ rawurlencode($article->titre) }}&body={{ rawurlencode(route('actualites.show',$article->slug)) }}">Partager par e-mail</a>
</article>
@if($similaires->isNotEmpty())<section class="max-w-7xl mx-auto px-6 pb-16">
<h2 class="text-2xl font-bold mb-8">À lire aussi</h2>
<div class="grid md:grid-cols-3 gap-8">
@foreach($similaires as $other)<x-article-card :article="$other"/>
@endforeach
</div>
</section>
@endif @endsection
