@extends('admin.layout')
@section('title', $article->exists ? 'Modifier l’actualité' : 'Créer une actualité')
@section('intro', 'Préparez vos articles et associez-les aux projets concernés.')
@section('content')
<form method="post" action="{{ $article->exists ? route('admin.articles.update',$article) : route('admin.articles.store') }}" enctype="multipart/form-data">
@csrf @if($article->exists) @method('PUT') @endif
<section class="editorial-section">
<h2>Article</h2>
<div class="editorial-grid">
@foreach(['titre'=>'Titre','slug'=>'Adresse de la page (slug)','seo_title'=>'Titre SEO','meta_description'=>'Méta-description'] as $field=>$label)<div>
<label for="a-{{ $field }}">{{ $label }}</label>
<input id="a-{{ $field }}" name="{{ $field }}" maxlength="{{ $field==='slug' ? 220 : 255 }}" value="{{ old($field,$article->$field) }}" @required($field==='titre')>
</div>
@endforeach
<div>
<label for="a-category">Catégorie</label>
<select id="a-category" name="category_id">
<option value="">Sans catégorie</option>
@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$article->category_id)==$category->id)>{{ $category->nom }}</option>
@endforeach
</select>
</div>
<div>
<label for="a-publication">Visibilité</label>
<select id="a-publication" name="publication">
<option value="brouillon" @selected(old('publication',$article->publication)==='brouillon')>Brouillon</option>
<option value="publie" @selected(old('publication',$article->publication)==='publie')>Publié</option>
</select>
</div>
</div>
<div class="form-group">
<label for="a-extrait">Extrait</label>
<textarea id="a-extrait" name="extrait" rows="3" maxlength="1000">{{ old('extrait',$article->extrait) }}</textarea>
</div>
<div class="form-group">
<label for="a-contenu">Contenu</label>
<p class="editorial-help" id="a-help">Texte simple. Utilisez ## au début d’une ligne pour un sous-titre, ### pour un sous-titre de niveau 3. Les liens internes s’écrivent [titre](/projets/adresse-du-projet). Le HTML n’est pas interprété.</p>
<textarea id="a-contenu" name="contenu" rows="18" required aria-describedby="a-help">{{ old('contenu',$article->contenu) }}</textarea>
</div>
</section>
<section class="editorial-section">
<h2>Image à la une</h2>
@if($article->image)<img src="{{ asset($article->image) }}" alt="{{ $article->image_alt }}" width="260">
<label>
<input type="checkbox" name="retirer_image" value="1">Retirer l’image actuelle</label>
@endif
<label for="a-image">Ajouter / remplacer l’image</label>
<input id="a-image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
<p class="editorial-help">JPEG, PNG ou WebP, 3 Mo maximum.</p>
<label for="a-alt">Description de l’image</label>
<input id="a-alt" name="image_alt" value="{{ old('image_alt',$article->image_alt) }}" maxlength="255">
</section>
<section class="editorial-section">
<h2>Projets associés</h2>
@forelse($projets as $projet)<label>
<input type="checkbox" name="projets[]" value="{{ $projet->id }}" @checked(in_array($projet->id,old('projets',$article->exists ? $article->projets->modelKeys() : [])))>{{ $projet->titre }}</label>
@empty<p>Aucun projet enregistré.</p>
@endforelse
</section>
<div class="editorial-actions">
<button class="btn btn-primary">Enregistrer</button>
@if($article->exists)<a class="btn btn-secondary" target="_blank" rel="noopener" href="{{ route('admin.articles.preview',$article) }}">Prévisualiser la version enregistrée</a>
@endif
<a class="btn btn-secondary" href="{{ route('admin.projets.index') }}#actualites">Retour aux actualités</a>
</div>
</form>
@endsection
