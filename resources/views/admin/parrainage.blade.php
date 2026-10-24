@extends('admin.layout')

@section('title', 'Programmes de parrainage')
@section('intro', 'Gérez les présentations publiées sur le site. Les demandes arrivent dans les messages de contact existants.')

@section('content')
    <section class="editorial-section">
        <h2>Un parcours de contact</h2>
        <p>Chaque programme invite le visiteur à échanger avec l’association. La mise en place du parrainage et les versements sont organisés ensuite avec votre équipe.</p>
        <p class="editorial-help">Les modifications enregistrées sont immédiatement visibles sur la page de parrainage et sur l’accueil.</p>
        <a href="{{ route('parrainage.index') }}" class="btn btn-secondary" target="_blank" rel="noopener">Voir la page publique</a>
    </section>

    @foreach($programmes as $programme)
        @php($hasOldInput = old('programme_code') === $programme->code)
        <section class="editorial-section" aria-labelledby="admin-programme-{{ $programme->code }}">
            <h2 id="admin-programme-{{ $programme->code }}">{{ $programme->titre }}</h2>
            <form method="post" action="{{ route('admin.parrainage.update', $programme->code) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="programme_code" value="{{ $programme->code }}">

                <div class="form-group">
                    <label for="{{ $programme->code }}-titre">Titre du programme</label>
                    <input id="{{ $programme->code }}-titre" name="titre" required maxlength="150"
                           value="{{ $hasOldInput ? old('titre') : $programme->titre }}">
                </div>
                <div class="form-group">
                    <label for="{{ $programme->code }}-accroche">Accroche</label>
                    <input id="{{ $programme->code }}-accroche" name="accroche" required maxlength="255"
                           value="{{ $hasOldInput ? old('accroche') : $programme->accroche }}">
                </div>
                <div class="form-group">
                    <label for="{{ $programme->code }}-description">Présentation du programme</label>
                    <textarea id="{{ $programme->code }}-description" name="description" required rows="5" maxlength="5000">{{ $hasOldInput ? old('description') : $programme->description }}</textarea>
                </div>

                @if($programme->code === \App\Models\ProgrammeParrainage::ENFANT)
                    <div class="form-group">
                        <label for="{{ $programme->code }}-montant">Contribution mensuelle (€)</label>
                        <input id="{{ $programme->code }}-montant" name="montant_mensuel" type="number" min="1" max="100000" step="0.01" required
                               value="{{ $hasOldInput ? old('montant_mensuel') : $programme->montant_mensuel_centimes / 100 }}">
                        <p class="editorial-help">L’équivalent FCFA est calculé automatiquement. Le site présente un soutien mensuel à organiser avec l’équipe.</p>
                    </div>
                @else
                    <p class="editorial-help">Le programme santé propose un montant mensuel libre. Aucun montant fixe n’est demandé.</p>
                @endif

                <fieldset class="form-group">
                    <legend>Photo du programme (facultative)</legend>
                    @if($programme->image)
                        <img src="{{ asset($programme->image) }}" alt="{{ $programme->image_alt }}"
                             style="width:100%;max-width:320px;height:200px;object-fit:cover;border-radius:12px;margin:12px 0;">
                        <label>
                            <input type="checkbox" name="retirer_image" value="1" @checked($hasOldInput && old('retirer_image'))>
                            Retirer la photo actuelle
                        </label>
                    @endif
                    <label for="{{ $programme->code }}-image">Ajouter ou remplacer la photo</label>
                    <input id="{{ $programme->code }}-image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                           aria-describedby="{{ $programme->code }}-image-help">
                    <p id="{{ $programme->code }}-image-help" class="editorial-help">JPEG, PNG ou WebP, 3 Mo maximum. Choisissez une photo de vos actions dont vous pouvez autoriser la publication.</p>
                    <label for="{{ $programme->code }}-image-alt">Description de la photo</label>
                    <input id="{{ $programme->code }}-image-alt" name="image_alt" maxlength="255"
                           value="{{ $hasOldInput ? old('image_alt') : $programme->image_alt }}">
                    <p class="editorial-help">Obligatoire lorsqu’une photo est publiée ; décrit son contenu pour les lecteurs d’écran.</p>
                </fieldset>

                <div class="editorial-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer ce programme</button>
                    <a href="{{ $programme->contact_url }}" class="btn btn-secondary">Vérifier le contact prérempli</a>
                </div>
            </form>
        </section>
    @endforeach
@endsection
