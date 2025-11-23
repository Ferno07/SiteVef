<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Association humanitaire Verre d'eau fraîche</title>
  <link rel="icon" type="image/png" href="{{ asset('Style1/images/logo.png') }}">
  <meta name="description" content="Bienvenue sur le site VEF. Produits, services et témoignages.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('Style1/css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('Style1/css/rejoindre.css') }}">
</head>
<body>
  
  
  <header class="site-header">
    <div class="header-wrapper">
      <div class="header-inner">
      <a class="logo" href="{{ url('/') }}">
        <img src="{{ asset('Style1/images/logo.png') }}" alt="Logo VEF">
      </a>
      <button class="nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false">☰</button>
      <nav class="main-nav" aria-label="Navigation principale">
        <ul>
          <li><a href="{{ url('/#hero') }}">Accueil</a></li>
          <li><a href="{{ url('/#about') }}">À propos</a></li>
          <li><a href="{{ url('/#services') }}">Nos projets</a></li>
          <li><a href="{{ url('/#contact') }}">Bénéficier</a></li>
         
          <li><a href="{{ route('rejoindre') }}">Nous rejoindre</a></li>

          <li><a href="{{ url('/#contact') }}">Contact</a></li>
        </ul>
      </nav>
      <a class="btn cta" href="{{ route('donation.index') }}">Faire un don</a>
      </div>
    </div>
  </header>
  





@yield('content')









    <footer id="contact" class="site-footer">
    <div class="footer-container">
      <div class="footer-left">
        <p class="footer-text" style="color: white; font-weight: bold;">
          Verre d'eau fraîche, agissons pour chacun, agissons pour tous.
        </p>
        <p class="footer-text" style="color: white; font-weight: bold;">
          ONG reconnue d'intérêt public. L'eau, c'est la vie.
          <br>Ensemble, partageons-la. <br> 
        </p>
        <p class="footer-text" style="color: white; font-weight: bold; text-align: center;">
          © 2025 Verre d'eau fraîche — Tous droits réservés.
        </p>
        
        
      </div>
      <div class="footer-right">
        <div class="footer-social">
          <a href="https://www.facebook.com/ONG.VERRE.D.EAU.FRAICHE?locale=fr_FR" aria-label="Facebook" class="footer-social-btn">
            <img src="{{ asset('Style1/images/facebook.jpg') }}" alt="Facebook">
          </a>
          <a href="#" aria-label="Tiktok" class="footer-social-btn">
            <img src="{{ asset('Style1/images/tiktkok.png') }}" alt="Tiktok">
          </a>
          <a href="https://www.linkedin.com/company/association-humanitaire-verre-d-eau-fraiche/posts/?feedView=all" aria-label="LinkedIn" class="footer-social-btn">
            <img src="{{ asset('Style1/images/link.png') }}" alt="LinkedIn">
          </a>
        </div>
      </div>
    </div>
  </footer>

<script src="{{ asset('Style1/js/script.js') }}"></script>
<script src="{{ asset('Style1/js/rejoindre.js') }}"></script>

</body>
</html> 