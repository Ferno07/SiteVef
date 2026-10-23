@extends('app')
@section('title', 'Actualités — Verre d’Eau Fraîche')
@section('content')<section class="max-w-7xl mx-auto px-6 py-16">
<p class="text-blue-700 font-semibold">SUR LE TERRAIN</p>
<h1 class="text-4xl font-bold mt-3">Actualités de l’association</h1>
<p class="mt-5 text-lg text-gray-600">Suivez nos actions, les avancées des projets et la vie de l’association.</p>
<form method="get" class="my-8 flex flex-wrap gap-3 items-center">
<label for="categorie">Catégorie</label>
<select id="categorie" name="categorie" class="rounded-lg border-gray-300">
<option value="">Toutes les catégories</option>
@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('categorie')==$category->id)>{{ $category->nom }}</option>
@endforeach
</select>
<button class="bg-blue-600 text-white rounded-full px-5 py-2">Filtrer</button>
</form>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
@forelse($articles as $article)<x-article-card :article="$article"/>
@empty<p class="text-gray-600">Aucune actualité publiée dans cette rubrique pour le moment.</p>
@endforelse
</div>
<div class="mt-10">{{ $articles->links() }}</div>
</section>
@endsection
