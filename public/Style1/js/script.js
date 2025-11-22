// Menu mobile
const navToggle = document.querySelector('.nav-toggle');
const mainNav = document.querySelector('.main-nav');
if (navToggle && mainNav) {
  navToggle.addEventListener('click', () => {
    const isOpen = mainNav.classList.toggle('open');
    navToggle.setAttribute('aria-expanded', String(isOpen));
  });
}

// Défilement fluide
const navLinks = document.querySelectorAll('a[href^="#"]');
navLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    const targetId = link.getAttribute('href');
    if (!targetId || targetId === '#') return;
    const target = document.querySelector(targetId);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      if (mainNav && mainNav.classList.contains('open')) {
        mainNav.classList.remove('open');
        navToggle?.setAttribute('aria-expanded', 'false');
      }
    }
  });
});

// Témoignages: slider simple par points
const quotes = Array.from(document.querySelectorAll('.quote'));
const dots = Array.from(document.querySelectorAll('.btn.dot'));
function setActive(index) {
  quotes.forEach((q, i) => q.classList.toggle('active', i === index));
  dots.forEach((d, i) => d.classList.toggle('active', i === index));
}

dots.forEach(dot => {
  dot.addEventListener('click', () => {
    const i = Number(dot.getAttribute('data-slide')) || 0;
    setActive(i);
  });
});

// Auto-rotation toutes les 6s
let current = 0;
if (quotes.length > 0) {
  setActive(0);
  setInterval(() => {
    current = (current + 1) % quotes.length;
    setActive(current);
  }, 6000);
}

// Hero: carrousel d'images
const heroSlides = Array.from(document.querySelectorAll('.hero-slide'));
const heroDots = Array.from(document.querySelectorAll('[data-hero-slide]'));
let heroCurrent = 0;

function setHeroActive(index) {
  heroSlides.forEach((s, i) => s.classList.toggle('active', i === index));
  heroDots.forEach((d, i) => d.classList.toggle('active', i === index));
}

if (heroSlides.length > 0) {
  setHeroActive(0);
  heroDots.forEach(dot => {
    dot.addEventListener('click', () => {
      const i = Number(dot.getAttribute('data-hero-slide')) || 0;
      heroCurrent = i;
      setHeroActive(heroCurrent);
    });
  });
  setInterval(() => {
    heroCurrent = (heroCurrent + 1) % heroSlides.length;
    setHeroActive(heroCurrent);
  }, 7000);
}

// Année dynamique dans le footer
const yearSpan = document.getElementById('year');
if (yearSpan) {
  yearSpan.textContent = String(new Date().getFullYear());
}

// Bouton Aller sur la carte (ouvre recherche OSM)
(() => {
  const btn = document.getElementById('mapGoBtn');
  if (!btn) return;
  btn.addEventListener('click', () => {
    const lieu = prompt('Où voulez-vous aller ? (ex: Paris, Dakar)');
    if (!lieu) return;
    const url = 'https://www.openstreetmap.org/search?query=' + encodeURIComponent(lieu);
    window.open(url, '_blank');
  });
})();

// Animation des images de la galerie (effet de zoom depuis le fond)
if ('IntersectionObserver' in window) {
  const galleryImages = document.querySelectorAll('.gallery-image');
  const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'scale(1)';
          entry.target.style.filter = 'blur(0)';
        }, index * 200);
      }
    });
  }, { threshold: 0.1 });

  galleryImages.forEach(img => {
    img.style.opacity = '0';
    img.style.transform = 'scale(0.8)';
    img.style.filter = 'blur(10px)';
    img.style.transition = 'opacity 0.8s ease, transform 0.8s ease, filter 0.8s ease';
    imageObserver.observe(img);
  });
}

// Animation des cards des projets (zoom depuis le fond)
if ('IntersectionObserver' in window) {
  const projectCards = document.querySelectorAll('.card');
  const cardObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'scale(1)';
          entry.target.style.filter = 'blur(0)';
        }, index * 150);
        cardObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  projectCards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'scale(0.9)';
    card.style.filter = 'blur(5px)';
    card.style.transition = 'opacity 0.7s ease, transform 0.7s ease, filter 0.7s ease';
    cardObserver.observe(card);
  });
}

// Interaction pour le bouton "En savoir plus" dans les cards
const learnMoreBtns = document.querySelectorAll('.learn-more-btn');
learnMoreBtns.forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    const cardIndex = btn.getAttribute('data-card');
    const card = btn.closest('.card');
    const details = card.querySelector('.card-details');
    
    if (details.style.display === 'none') {
      details.style.display = 'block';
      details.style.animation = 'fadeInUp 0.5s ease';
      btn.textContent = 'Voir moins';
    } else {
      details.style.display = 'none';
      btn.textContent = 'En savoir plus';
    }
  });
});

// Animation de défilement automatique pour les cartes de projets avec contrôle manuel
(function() {
  const cardsContainer = document.querySelector('.cards-animated');
  const scrollWrapper = document.querySelector('.cards-scroll');
  if (!cardsContainer || !scrollWrapper) return;
  
  let isManualScrolling = false;
  let manualScrollTimeout = null;
  let currentScrollPosition = 0;
  let animationStartTime = 0;
  let isDragging = false;
  let startX = 0;
  let scrollLeft = 0;
  let animationId = null;
  
  function updateAnimation() {
    const cards = cardsContainer.querySelectorAll('.card');
    if (cards.length < 10) return; // Besoin d'au moins 10 cartes (5 originales + 5 dupliquées)
    
    // Méthode plus précise : calculer la distance entre la première et la sixième carte
    // (la première carte dupliquée)
    const firstCard = cards[0];
    const sixthCard = cards[5];
    
    if (firstCard && sixthCard) {
      const firstRect = firstCard.getBoundingClientRect();
      const sixthRect = sixthCard.getBoundingClientRect();
      
      // Distance entre le début de la première carte et le début de la sixième
      const scrollDistance = sixthRect.left - firstRect.left;
      
      // Définir la variable CSS pour l'animation
      cardsContainer.style.setProperty('--scroll-distance', `-${scrollDistance}px`);
    } else {
      // Méthode de secours : calculer manuellement
      let totalWidth = 0;
      const computedStyle = window.getComputedStyle(cardsContainer);
      const gapValue = computedStyle.gap || '1.25rem';
      const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize) || 16;
      const gapInPx = gapValue.includes('rem') 
        ? parseFloat(gapValue) * rootFontSize 
        : parseFloat(gapValue);
      
      for (let i = 0; i < 5; i++) {
        const card = cards[i];
        const cardRect = card.getBoundingClientRect();
        totalWidth += cardRect.width;
        if (i < 4) {
          totalWidth += gapInPx;
        }
      }
      
      cardsContainer.style.setProperty('--scroll-distance', `-${totalWidth}px`);
    }
  }
  
  // Fonction pour gérer le défilement manuel
  function handleManualScroll(offset) {
    if (!isManualScrolling) {
      isManualScrolling = true;
      scrollWrapper.classList.add('manual-scroll');
      // Arrêter l'animation CSS et sauvegarder la position actuelle
      const currentTransform = window.getComputedStyle(cardsContainer).transform;
      if (currentTransform && currentTransform !== 'none') {
        const matrix = new DOMMatrix(currentTransform);
        const currentX = matrix.e; // Position X actuelle
        currentOffset = Math.abs(currentX);
      }
      cardsContainer.style.animation = 'none';
    }
    
    // Mettre à jour la position de défilement
    currentScrollPosition = offset;
    currentOffset = offset;
    
    // Appliquer la position manuelle au conteneur
    cardsContainer.style.transform = `translateX(-${currentScrollPosition}px)`;
    
    // Réinitialiser le timer
    clearTimeout(manualScrollTimeout);
    manualScrollTimeout = setTimeout(() => {
      // Reprendre l'animation après 2 secondes d'inactivité
      resumeAutoScroll();
    }, 2000);
  }
  
  // Reprendre le défilement automatique
  function resumeAutoScroll() {
    if (isManualScrolling) {
      isManualScrolling = false;
      scrollWrapper.classList.remove('manual-scroll');
      
      // Calculer la position relative dans le cycle
      const scrollDistance = parseFloat(cardsContainer.style.getPropertyValue('--scroll-distance') || '0');
      const absScrollDistance = Math.abs(scrollDistance);
      
      // Normaliser la position pour qu'elle soit dans la première boucle
      const normalizedPosition = currentScrollPosition % absScrollDistance;
      
      // Reprendre l'animation depuis la position actuelle
      const animationDuration = 40; // secondes
      const progress = normalizedPosition / absScrollDistance;
      const elapsedTime = progress * animationDuration;
      
      // Mettre à jour currentOffset pour la nouvelle position
      currentOffset = normalizedPosition;
      
      // Réinitialiser l'animation
      cardsContainer.style.animation = 'none';
      cardsContainer.style.setProperty('--manual-offset', '0px');
      cardsContainer.offsetHeight; // Force reflow
      
      // Reprendre l'animation avec la position actuelle via animation-delay
      cardsContainer.style.transform = `translateX(-${normalizedPosition}px)`;
      cardsContainer.style.animation = `scrollCards ${animationDuration}s linear infinite`;
      cardsContainer.style.animationDelay = `-${elapsedTime}s`;
    }
  }
  
  // Variables pour le glisser-déposer
  let currentOffset = 0;
  
  // Défilement avec la molette de la souris
  scrollWrapper.addEventListener('wheel', function(e) {
    e.preventDefault();
    const delta = e.deltaY || e.deltaX;
    currentOffset += delta * 0.8; // Vitesse de défilement ajustable
    
    // Limiter le défilement pour éviter de dépasser
    const scrollDistance = parseFloat(cardsContainer.style.getPropertyValue('--scroll-distance') || '0');
    const absScrollDistance = Math.abs(scrollDistance);
    const maxOffset = absScrollDistance * 2; // Permettre 2 cycles
    currentOffset = Math.max(0, Math.min(currentOffset, maxOffset));
    
    handleManualScroll(currentOffset);
  }, { passive: false });
  
  // Glisser-déposer (drag)
  scrollWrapper.addEventListener('mousedown', function(e) {
    isDragging = true;
    startX = e.pageX;
    scrollWrapper.style.cursor = 'grabbing';
    handleManualScroll(currentOffset);
    e.preventDefault();
  });
  
  scrollWrapper.addEventListener('mouseleave', function() {
    if (isDragging) {
      isDragging = false;
      scrollWrapper.style.cursor = 'grab';
    }
  });
  
  scrollWrapper.addEventListener('mouseup', function() {
    if (isDragging) {
      isDragging = false;
      scrollWrapper.style.cursor = 'grab';
    }
  });
  
  scrollWrapper.addEventListener('mousemove', function(e) {
    if (!isDragging) return;
    e.preventDefault();
    const deltaX = startX - e.pageX;
    currentOffset += deltaX * 1.5; // Vitesse de glissement
    
    // Limiter le défilement
    const scrollDistance = parseFloat(cardsContainer.style.getPropertyValue('--scroll-distance') || '0');
    const absScrollDistance = Math.abs(scrollDistance);
    const maxOffset = absScrollDistance * 2;
    currentOffset = Math.max(0, Math.min(currentOffset, maxOffset));
    
    startX = e.pageX;
    handleManualScroll(currentOffset);
  });
  
  // Support tactile (mobile)
  let touchStartX = 0;
  let touchStartOffset = 0;
  
  scrollWrapper.addEventListener('touchstart', function(e) {
    touchStartX = e.touches[0].pageX;
    touchStartOffset = currentOffset;
    handleManualScroll(currentOffset);
    e.preventDefault();
  }, { passive: false });
  
  scrollWrapper.addEventListener('touchmove', function(e) {
    if (!touchStartX) return;
    e.preventDefault();
    const deltaX = touchStartX - e.touches[0].pageX;
    currentOffset = touchStartOffset + (deltaX * 1.5);
    
    // Limiter le défilement
    const scrollDistance = parseFloat(cardsContainer.style.getPropertyValue('--scroll-distance') || '0');
    const absScrollDistance = Math.abs(scrollDistance);
    const maxOffset = absScrollDistance * 2;
    currentOffset = Math.max(0, Math.min(currentOffset, maxOffset));
    
    handleManualScroll(currentOffset);
  }, { passive: false });
  
  scrollWrapper.addEventListener('touchend', function() {
    touchStartX = 0;
  });
  
  // Attendre que les images soient chargées
  function initAnimation() {
    const images = cardsContainer.querySelectorAll('.card img');
    let loadedCount = 0;
    const totalImages = images.length;
    
    if (totalImages === 0) {
      updateAnimation();
      return;
    }
    
    images.forEach(img => {
      if (img.complete) {
        loadedCount++;
      } else {
        img.addEventListener('load', () => {
          loadedCount++;
          if (loadedCount === totalImages) {
            updateAnimation();
          }
        });
        img.addEventListener('error', () => {
          loadedCount++;
          if (loadedCount === totalImages) {
            updateAnimation();
          }
        });
      }
    });
    
    if (loadedCount === totalImages) {
      updateAnimation();
    }
  }
  
  // Mettre à jour au chargement et au redimensionnement
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAnimation);
  } else {
    initAnimation();
  }
  
  window.addEventListener('resize', () => {
    setTimeout(() => {
      updateAnimation();
      if (!isManualScrolling) {
        resumeAutoScroll();
      }
    }, 100);
  });
  
  // Utiliser ResizeObserver pour détecter les changements de taille
  if ('ResizeObserver' in window) {
    const resizeObserver = new ResizeObserver(() => {
      setTimeout(() => {
        updateAnimation();
        if (!isManualScrolling) {
          resumeAutoScroll();
        }
      }, 50);
    });
    const firstCard = cardsContainer.querySelector('.card');
    if (firstCard) {
      resizeObserver.observe(firstCard);
    }
  }
})(); 