
@extends('app')
@section('content')


  <main>
    <section id="hero" class="hero">
      <div class="hero-media" aria-hidden="true">
        <div class="hero-slides">
          <img class="hero-slide active" src="{{ asset('Style1/images/header1.jpg') }}" alt="En-tête 1" />
          <img class="hero-slide" src="{{ asset('Style1/images/header2.jpg') }}" alt="En-tête 2" />
          <img class="hero-slide" src="{{ asset('Style1/images/header3.jpg') }}" alt="En-tête 3" />
        </div>
      </div>
      <div class="container hero-content">
        <h1 class="headline hero-animate" id="bienvenue" style="animation-delay: 0s; color: white;">
  BIENVENUE A VERRE D'EAU FRAICHE
</h1>

        <p class="eyebrow hero-animate" style="animation-delay: 0.5s;">
          Agissons pour chacun agissons pour tous
        </p>
        
        <p class="subhead hero-animate" style="animation-delay: 1s;">Nous oeuvrons pour améliorer la vie des plus vulnérables.</p>
        <div class="hero-actions hero-animate" style="animation-delay: 1.5s;">
          <a class="btn primary" href="#join">Nous rejoindre</a>
          <a class="btn ghost" href="#services">Discover our actions</a>
        </div>
        <div class="hero-dots" role="tablist" aria-label="Changer d'image">
          <button class="btn dot" data-hero-slide="0" aria-label="Image 1"></button>
          <button class="btn dot" data-hero-slide="1" aria-label="Image 2"></button>
          <button class="btn dot" data-hero-slide="2" aria-label="Image 3"></button>
        </div>
      </div>
    </section>

    <section id="about" class="section about">
      <div class="container">
        <h2> A PROPOS DE VERRE D'EAU FRAICHE</h2>
        <p class="about-intro">Nos principales activités, présentées simplement, montrent comment nous œuvrons chaque jour pour améliorer la vie des plus vulnérables.</p> 
        
        <div class="about-grid">
          <article class="about-card">
            <svg class="about-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-label="Mission icon">
              <circle cx="12" cy="12" r="9"/>
              <circle cx="12" cy="12" r="3"/>
              <path d="M12 3v3M21 12h-3M12 21v-3M3 12h3"/>
              <path d="M16 8l5-5"/>
              <polyline points="16,8 20,4 20,8"/>
            </svg>
            <h3>Mission</h3>
            <p class="about-desc">Nous existons pour investir dans l’épanouissement, l’éducation ; et l’avenir des personnes les plus faibles et 
              vulnérables de la société.</p>
          </article>
          <article class="about-card">
            <svg class="about-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-label="Vision icon">
              <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            <h3>Vision</h3>
            <p class="about-desc">Nous rêvons d’être d’ici 2030 la meilleure organisation des jeunes qui agit pour la transformation des 
              conditions des vies des personne les plus faibles et vulnérables de la société</p>
          </article>
          <article class="about-card">
            <svg class="about-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-label="Values icon">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
            <h3>Valeur</h3>
            <p class="about-desc">Des valeurs de confiance, de transparence et d'exigence au quotidien.fenb,vef nb bc bn dcbc db d bd dbn d nbbdcvgdvgdvgdcvchvdcvgndcdhc jdhsjhv jsvds jv b </p>
          </article>
        </div>
      </div>
    </section>

    <section id="gallery" class="section gallery">
      <div class="container">
        <h2>NOS ACTIONS</h2>
        <div class="gallery-grid">
          <div class="gallery-item top-left">
            <img src="header/ecole.jpg" alt="Soutien scolaire" class="gallery-image">
            <div class="gallery-overlay">
              <p>Accès à l'éducation pour tous les enfants.</p>
            </div>
          </div>
          <div class="gallery-item top-right">
            <img src="header/entrepreneuriat-mots.jpg" alt="Entrepreneuriat" class="gallery-image">
            <div class="gallery-overlay">
              <p>Encourager l'esprit d'initiative des jeunes.</p>
            </div>
          </div>
          <div class="gallery-item bottom-left">
            <img src="header/soins.jpg" alt="Accès aux soins" class="gallery-image">
            <div class="gallery-overlay">
              <p>Des soins de santé essentiels à proximité.</p>
            </div>
          </div>
          <div class="gallery-item bottom-right">
            <img src="header/autonomisationfemmes.jpg" alt="Autonomisation des femmes" class="gallery-image">
            <div class="gallery-overlay">
              <p>Renforcer le leadership féminin au quotidien.</p>
            </div>
          </div>
        </div>
        <div class="gallery-button">
          <a class="btn primary" href="{{ route('donation.index') }}">Faire un don</a>
        </div>
      </div>
    </section>

    <section id="services" class="section services">
      <div class="container">
        <h2>Nos projets en cours</h2>
      </div>
      <div class="cards-scroll-wrapper">
    <div class="cards-scroll">
        <div class="cards cards-animated">

            {{-- PREMIÈRE SÉRIE (vraie) --}}
            @foreach($projets as $index => $projet)
            @php $newIndex = $index + count($projets); @endphp
                <article class="card">
                    <img src="{{ asset($projet->image_path) }}" alt="{{ $projet->titre }}">
                    <div class="card-content">
                        <h3>{{ $projet->titre }}</h3>
                        <p>{{ $projet->description_courte }}</p>

                        <div class="card-details" style="display: none;">
                            <p>{{ $projet->description_longue }}</p>
                        </div>

                        <button class="btn small learn-more-btn" data-card="{{ $index }}">En savoir plus</button>
                    </div>
                </article>
            @endforeach

            {{-- DEUXIÈME SÉRIE (dupliquée pour l'infinite scroll) --}}
            @foreach($projets as $index => $projet)
            @php $newIndex = $index + count($projets); @endphp
                <article class="card">
                    <img src="{{ asset($projet->image_path) }}" alt="{{ $projet->titre }}">
                    <div class="card-content">
                        <h3>{{ $projet->titre }}</h3>
                        <p>{{ $projet->description_courte }}</p>

                        <div class="card-details" style="display: none;">
                            <p>{{ $projet->description_longue }}</p>
                        </div>

                        <button class="btn small learn-more-btn" data-card="{{ $index }}">En savoir plus</button>
                    </div>
                </article>
            @endforeach

        </div>
    </div>
</div>

    </section>
        <section id="info-section" class="section info-section">
      <div class="info-section-wrapper">
        <div class="info-grid">
          <div class="info-content">
            <h2>Notre Engagement</h2>
            <p>Nous sommes une organisation dédiée à l'amélioration des conditions de vie des personnes les plus vulnérables. Notre mission est de créer un impact durable et positif dans les communautés que nous servons. À travers l'éducation, l'autonomisation et l'accès aux soins de santé, nous travaillons chaque jour pour construire un avenir meilleur pour tous.</p>
          </div>
          <div class="info-image-wrapper">
            <img src="header/header1.jpg" alt="Notre mission" class="info-image">
          </div>
        </div>
        <div class="info-button-container">
          <a class="btn primary info-button" href="rejoindre.html">Rejoindre notre équipe</a>
        </div>
      </div>
      </div>
    </section>

    <section id="volunteer" class="section volunteer">
      <div class="container">
        <h2>Bénévolat</h2>
        <div class="volunteer-grid">
          <div class="volunteer-card">
            <img src="header/ecole.jpg" alt="Bénévolat éducation" class="volunteer-image">
            <div class="volunteer-content">
              <h3>Stagee</h3>
              <p>Participez à nos programmes éducatifs et contribuez à l'avenir des enfants.</p>
              <a href="rejoindre.html" class="volunteer-btn">Nous rejoindre</a>
            </div>
          </div>
          <div class="volunteer-card">
            <img src="header/soins.jpg" alt="Bénévolat santé" class="volunteer-image">
            <div class="volunteer-content">
              <h3>Mission</h3>
              <p>Aidez-nous à apporter des soins de santé aux communautés les plus vulnérables.</p>
              <a href="rejoindre.html" class="volunteer-btn">Nous rejoindre</a>
            </div>
          </div>
          <div class="volunteer-card">
            <img src="header/entrepreneuriat-mots.jpg" alt="Bénévolat entrepreneuriat" class="volunteer-image">
            <div class="volunteer-content">
              <h3>Service Civique</h3>
              <p>Soutenez l'autonomisation économique des entrepreneurs locaux.</p>
              <a href="rejoindre.html" class="volunteer-btn">Nous rejoindre</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="support" class="section support">
      <div class="container">
        <h2>Soutenez-nous</h2>
        <div class="support-content">
          <p class="support-text">Votre soutien est essentiel pour mener à bien nos missions humanitaires. Chaque contribution, aussi modeste soit-elle, a un impact réel sur la vie des personnes que nous aidons. Avec votre générosité, nous pouvons continuer à construire des écoles, améliorer l'accès aux soins de santé, soutenir l'autonomisation des femmes et créer des opportunités économiques durables. Ensemble, nous transformons des vies et bâtissons un avenir meilleur pour les communautés les plus vulnérables. Rejoignez-nous dans cette belle aventure de solidarité et de compassion. Votre engagement fait toute la différence.</p>
          <a href="{{ route('donation.index') }}" class="btn primary support-button">Donnez le sourire</a>
        </div>
      </div>
    </section>

    <section id="map" class="section map">
      <div class="container">
        <div class="map-section">
          <div class="map-embed">
            <iframe class="map-frame" title="Carte du Bénin" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.openstreetmap.org/export/embed.html?bbox=0.5%2C6.0%2C3.5%2C12.0&layer=mapnik&marker=2.3158%2C6.4969">
            </iframe>
          </div>
          <p class="map-text">Vous souhaitez devenir bénévole, partenaire ou simplement en savoir plus ?</p>
          <a href="#contact" class="btn primary map-contact-btn">Contactez-nous</a>
          <div class="map-contact-panel">
            <div class="map-contact-info">
              <h3>Notre adresse</h3>
              <p>ONG Verre d'eau fraîche</p>
              <p><span class="map-contact-icon">📍</span>Lot 1230, Quartier Fidjrossè, Cotonou, Bénin</p>
              <p><span class="map-contact-icon">📞</span><a href="tel:+22997000000">+229 97 00 00 00</a></p>
              <p><span class="map-contact-icon">✉️</span><a href="mailto:contact@verredeaufraiche.org">contact@verredeaufraiche.org</a></p>
              <p><span class="map-contact-icon">🕒</span>Lun - Ven, 8h à 17h</p>
            </div>
            <form        method="POST" action="{{ route('message') }}"          class="map-contact-form">
              @csrf
              <div class="form-row">
                <label for="contactNom">Nom</label>
                <input type="text" id="contactNom" name="nom" placeholder="Votre nom" required>
              </div>
              <div class="form-row">
                <label for="contactPrenom">Prénom</label>
                <input type="text" id="contactPrenom" name="prenom" placeholder="Votre prénom" required>
              </div>
              <div class="form-row">
                <label for="contactEmail">Email</label>
                <input type="email" id="contactEmail" name="email" placeholder="vous@example.com" required>
              </div>
              <div class="form-row form-row-full">
                <label for="contactObjet">Objet</label>
                <input type="text" id="contactObjet" name="objet" placeholder="Sujet de votre message" required>
              </div>
              <div class="form-row">
                <label for="contactMessage">Message</label>
                <textarea id="contactMessage" name="message" rows="4" placeholder="Écrivez votre message ici" required></textarea>
              </div>
              <button type="submit" class="btn primary map-form-submit">Envoyer</button>
            </form>
          </div>
        </div>
      </div>
    </section>



  </main>

  @endsection

