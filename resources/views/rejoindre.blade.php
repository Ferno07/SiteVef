@extends('app')
@section('content')

  <main>
    <section class="join-hero">
      <div class="container">
        <div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        <h1>Rejoignez notre association</h1>
        <p class="join-subtitle">Participez à nos actions humanitaires et contribuez à améliorer la vie des communautés</p>
      </div>
    </section>

    <section class="join-form-section">
      <div class="container">
        <form class="join-form"    method="POST" action="{{ route('candidature.store') }}" novalidate   novalidate>
         @csrf
        <div class="form-section">
            <h2>Informations personnelles</h2>
            
            <div class="form-row">
              <div class="form-group">
                <label for="nom">Nom <span class="required">*</span></label>
                <input type="text" id="nom" name="nom" required>
                <span class="error-message"></span>
              </div>
              
              <div class="form-group">
                <label for="prenom">Prénom <span class="required">*</span></label>
                <input type="text" id="prenom" name="prenom" required>
                <span class="error-message"></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="dateNaissance">Date de naissance <span class="required">*</span></label>
                <input type="date" id="dateNaissance" name="dateNaissance" required>
                <span class="error-message"></span>
              </div>
              
              <div class="form-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="email" id="email" name="email" required>
                <span class="error-message"></span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="telephone">Téléphone <span class="required">*</span></label>
                <input type="tel" id="telephone" name="telephone" placeholder="+229 90 00 00 00" required>
                <span class="error-message"></span>
              </div>
              
              <div class="form-group">
                <label for="adresse">Adresse <span class="required">*</span></label>
                <input type="text" id="adresse" name="adresse" placeholder="Votre adresse complète" required>
                <span class="error-message"></span>
              </div>
            </div>
          </div>

          <div class="form-section">
            <h2>Votre engagement</h2>
            
            <div class="form-group">
              <label for="typeParticipation">Type de participation <span class="required">*</span></label>
              <select id="typeParticipation" name="typeParticipation" required>
                    <option value="">Sélectionnez une option</option>
                    <option value="stagiaire">Stagiaire</option>
                    <option value="benevole">Bénévole</option>
                    <option value="autre">Autre</option>
                </select>

              <span class="error-message"></span>
            </div>

            <div class="form-group" id="autreTypeGroup" style="display: none;">
              <label for="autreType">Précisez votre type de participation <span class="required">*</span></label>
              <input type="text" id="autreType" name="autreType" placeholder="Ex: Partenaire, Consultant, etc.">
              <span class="error-message"></span>
            </div>

            <div class="form-group">
              <label for="disponibilites">Disponibilités <span class="required">*</span></label>
              <textarea id="disponibilites" name="disponibilites" rows="3" placeholder="Ex: Disponible les week-ends, 2 jours par semaine, etc." required></textarea>
              <span class="error-message"></span>
            </div>

            <div class="form-group">
              <label for="preferenceAction">Préférence d'action <span class="required">*</span></label>
              <div class="radio-group">
                <label class="radio-option">
                  <input type="radio" name="preferenceAction" value="locale" required>
                  <span>Locale</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="preferenceAction" value="nationale" required>
                  <span>Nationale</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="preferenceAction" value="internationale" required>
                  <span>Internationale</span>
                </label>
              </div>
              <span class="error-message"></span>
            </div>

            <div class="form-group">
              <label for="motivation">Lettre de motivation <span class="required">*</span></label>
              <textarea id="motivation" name="motivation" rows="6" placeholder="Expliquez pourquoi vous souhaitez rejoindre notre association et ce que vous pouvez apporter..." required></textarea>
              <span class="error-message"></span>
            </div>
          </div>

          <div class="form-section">
            <div class="form-group checkbox-group">
              <label class="checkbox-label">
                <input type="checkbox" id="rgpd" name="rgpd" value="1" required>
                <span>J'accepte que mes données personnelles soient utilisées conformément à la politique de confidentialité et au RGPD. <span class="required">*</span></span>
              </label>
              <span class="error-message"></span>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Envoyer ma candidature</button>
            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
          </div>
        </form>
      </div>
    </section>
  </main>
  @endsection