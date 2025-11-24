// Script pour la page d'administration

// Gestion de la navigation
document.addEventListener('DOMContentLoaded', function() {
  const navItems = document.querySelectorAll('.nav-item');
  const panels = document.querySelectorAll('.admin-panel');

  navItems.forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Retirer la classe active de tous les items
      navItems.forEach(nav => nav.classList.remove('active'));
      panels.forEach(panel => panel.classList.remove('active'));
      
      // Ajouter la classe active à l'item cliqué
      this.classList.add('active');
      
      // Afficher le panel correspondant
      const panelId = this.getAttribute('data-panel');
      const targetPanel = document.getElementById(panelId);
      if (targetPanel) {
        targetPanel.classList.add('active');
      }
    });
  });

  // Initialisation du stockage local
  initializeStorage();

  // Gestion des formulaires
  setupForms();

  // Afficher les données existantes
  loadAllData();

  // Mettre à jour les statistiques
  updateStats();
});

// Initialiser le localStorage
function initializeStorage() {
  const keys = ['projets', 'galerie', 'benevoles', 'temoignages'];
  keys.forEach(key => {
    if (!localStorage.getItem(key)) {
      localStorage.setItem(key, JSON.stringify([]));
    }
  });
}

// Configuration des formulaires
function setupForms() {
  // Formulaire projets
  const projetForm = document.getElementById('projet-form');
  if (projetForm) {
    projetForm.addEventListener('submit', handleProjetSubmit);
    setupImagePreview('projet-image', 'projet-image-preview');
  }

  // Formulaire galerie
  const galerieForm = document.getElementById('galerie-form');
  if (galerieForm) {
    galerieForm.addEventListener('submit', handleGalerieSubmit);
    setupImagePreview('galerie-image', 'galerie-image-preview');
  }

  // Formulaire bénévoles
  const benevoleForm = document.getElementById('benevole-form');
  if (benevoleForm) {
    benevoleForm.addEventListener('submit', handleBenevoleSubmit);
    setupImagePreview('benevole-image', 'benevole-image-preview');
  }

  // Formulaire témoignages
  const temoignageForm = document.getElementById('temoignage-form');
  if (temoignageForm) {
    temoignageForm.addEventListener('submit', handleTemoignageSubmit);
  }

  // Formulaire paramètres
  const settingsForm = document.getElementById('settings-form');
  if (settingsForm) {
    settingsForm.addEventListener('submit', handleSettingsSubmit);
  }

  // Boutons d'export
  document.getElementById('export-projets')?.addEventListener('click', () => exportData('projets'));
  document.getElementById('export-galerie')?.addEventListener('click', () => exportData('galerie'));
  document.getElementById('export-all')?.addEventListener('click', exportAllData);

  // Boutons de rafraîchissement
 
  document.getElementById('refresh-candidatures')?.addEventListener('click', loadCandidatures);

  // Recherche et filtres
  document.getElementById('messages-search')?.addEventListener('input', filterMessages);
  document.getElementById('candidatures-search')?.addEventListener('input', filterCandidatures);
  document.getElementById('candidatures-filter')?.addEventListener('change', filterCandidatures);

  // Modals
  setupModals();

  // Charger les données depuis l'API au chargement
 
  loadCandidatures();
}

// Prévisualisation d'image
function setupImagePreview(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);

  if (input && preview) {
    input.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
      } else {
        preview.innerHTML = '';
      }
    });
  }
}

// Gestion du formulaire projets
async function handleProjetSubmit(e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);


  

  try {
    const response = await fetch(`${API_BASE_URL}/projets`, {
  method: 'POST',
  body: formData
});
  

    if (!response.ok) throw new Error('Erreur lors de l\'envoi du projet');

    const data = await response.json();
    alert('Projet ajouté avec succès !');

    // Optionnel : rafraîchir la liste des projets côté frontend
    loadAllData();

    form.reset();
    document.getElementById('projet-image-preview').innerHTML = '';
  } catch (error) {
    console.error(error);
    alert('Erreur lors de l\'enregistrement du projet');
  }
}


// Gestion du formulaire galerie
function handleGalerieSubmit(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const imageFile = document.getElementById('galerie-image').files[0];
  
  if (!imageFile) {
    alert('Veuillez sélectionner une image');
    return;
  }

  const reader = new FileReader();
  reader.onload = function(e) {
    const image = {
      id: Date.now(),
      image: e.target.result,
      texte: formData.get('texte') || '',
      position: formData.get('position') || 'top-left',
      date: new Date().toISOString()
    };

    // Sauvegarder dans localStorage
    const galerie = JSON.parse(localStorage.getItem('galerie') || '[]');
    galerie.push(image);
    localStorage.setItem('galerie', JSON.stringify(galerie));

    // Afficher l'image dans la liste
    displayGalerie();
    updateStats();
    addActivity('Nouvelle image ajoutée à la galerie');
    
    // Réinitialiser le formulaire
    document.getElementById('galerie-form').reset();
    document.getElementById('galerie-image-preview').innerHTML = '';
    
    alert('Image ajoutée avec succès !');
  };
  reader.readAsDataURL(imageFile);
}

// Gestion du formulaire bénévoles
function handleBenevoleSubmit(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const imageInput = document.getElementById('benevole-image');
  const imageFile = imageInput.files[0];
  
  if (imageFile) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const benevole = {
        id: Date.now(),
        nom: formData.get('nom'),
        role: formData.get('role') || '',
        image: e.target.result,
        date: new Date().toISOString()
      };

      // Sauvegarder dans localStorage
      const benevoles = JSON.parse(localStorage.getItem('benevoles') || '[]');
      benevoles.push(benevole);
      localStorage.setItem('benevoles', JSON.stringify(benevoles));

      // Afficher le bénévole dans la liste
      displayBenevoles();
      updateStats();
      addActivity(`Nouveau bénévole ajouté : ${benevole.nom}`);
      
      // Réinitialiser le formulaire
      document.getElementById('benevole-form').reset();
      document.getElementById('benevole-image-preview').innerHTML = '';
      
      alert('Bénévole ajouté avec succès !');
    };
    reader.readAsDataURL(imageFile);
  } else {
    const benevole = {
      id: Date.now(),
      nom: formData.get('nom'),
      role: formData.get('role') || '',
      image: null,
      date: new Date().toISOString()
    };

    // Sauvegarder dans localStorage
    const benevoles = JSON.parse(localStorage.getItem('benevoles') || '[]');
    benevoles.push(benevole);
    localStorage.setItem('benevoles', JSON.stringify(benevoles));

    // Afficher le bénévole dans la liste
    displayBenevoles();
    updateStats();
    addActivity(`Nouveau bénévole ajouté : ${benevole.nom}`);
    
    // Réinitialiser le formulaire
    document.getElementById('benevole-form').reset();
    document.getElementById('benevole-image-preview').innerHTML = '';
    
    alert('Bénévole ajouté avec succès !');
  }
}

// Gestion du formulaire témoignages
function handleTemoignageSubmit(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const temoignage = {
    id: Date.now(),
    auteur: formData.get('auteur'),
    texte: formData.get('texte'),
    date: new Date().toISOString()
  };

  // Sauvegarder dans localStorage
  const temoignages = JSON.parse(localStorage.getItem('temoignages') || '[]');
  temoignages.push(temoignage);
  localStorage.setItem('temoignages', JSON.stringify(temoignages));

  // Afficher le témoignage dans la liste
  displayTemoignages();
  updateStats();
  addActivity(`Nouveau témoignage ajouté : ${temoignage.auteur}`);
  
  // Réinitialiser le formulaire
  e.target.reset();
  
  alert('Témoignage ajouté avec succès !');
}

// Gestion du formulaire paramètres
function handleSettingsSubmit(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const settings = {
    titre: formData.get('titre'),
    description: formData.get('description'),
    date: new Date().toISOString()
  };

  localStorage.setItem('settings', JSON.stringify(settings));
  addActivity('Paramètres mis à jour');
  
  alert('Paramètres enregistrés avec succès !');
}


// Afficher les projets
function displayProjets() {
  const container = document.getElementById('projets-list');
  const projets = JSON.parse(localStorage.getItem('projets') || '[]');
  
  if (projets.length === 0) {
    container.innerHTML = '<p class="empty-state">Aucun projet ajouté pour le moment</p>';
    return;
  }

  container.innerHTML = projets.map(projet => `
    <div class="item-card">
      ${projet.image ? `<img src="${projet.image}" alt="${escapeHtml(projet.titre)}" class="item-image">` : ''}
      <div class="item-content">
        <h3>${escapeHtml(projet.titre)}</h3>
        <p>${escapeHtml(projet.description || 'Aucune description')}</p>
        ${projet.descriptionLongue ? `<p style="margin-top: 0.5rem; color: #94a3b8; font-size: 0.9rem;">${escapeHtml(projet.descriptionLongue)}</p>` : ''}
      </div>
      <div class="item-actions">
        <button class="btn btn-danger btn-small" onclick="deleteProjet(${projet.id})">Supprimer</button>
      </div>
    </div>
  `).join('');
}

// Afficher la galerie
function displayGalerie() {
  const container = document.getElementById('galerie-list');
  const galerie = JSON.parse(localStorage.getItem('galerie') || '[]');
  
  if (galerie.length === 0) {
    container.innerHTML = '<p class="empty-state">Aucune image ajoutée pour le moment</p>';
    return;
  }

  container.innerHTML = galerie.map(image => `
    <div class="gallery-item-admin">
      <img src="${image.image}" alt="Galerie">
      ${image.texte ? `<div class="item-overlay">${escapeHtml(image.texte)}</div>` : ''}
      <div class="item-actions" style="position: absolute; top: 0.5rem; right: 0.5rem;">
        <button class="btn btn-danger btn-small" onclick="deleteGalerie(${image.id})">Supprimer</button>
      </div>
    </div>
  `).join('');
}

// Afficher les bénévoles
function displayBenevoles() {
  const container = document.getElementById('benevoles-list');
  const benevoles = JSON.parse(localStorage.getItem('benevoles') || '[]');
  
  if (benevoles.length === 0) {
    container.innerHTML = '<p class="empty-state">Aucun bénévole ajouté pour le moment</p>';
    return;
  }

  container.innerHTML = benevoles.map(benevole => `
    <div class="item-card">
      ${benevole.image ? `<img src="${benevole.image}" alt="${escapeHtml(benevole.nom)}" class="item-image">` : ''}
      <div class="item-content">
        <h3>${escapeHtml(benevole.nom)}</h3>
        <p>${escapeHtml(benevole.role || 'Aucun rôle spécifié')}</p>
      </div>
      <div class="item-actions">
        <button class="btn btn-danger btn-small" onclick="deleteBenevole(${benevole.id})">Supprimer</button>
      </div>
    </div>
  `).join('');
}

// Afficher les témoignages
function displayTemoignages() {
  const container = document.getElementById('temoignages-list');
  const temoignages = JSON.parse(localStorage.getItem('temoignages') || '[]');
  
  if (temoignages.length === 0) {
    container.innerHTML = '<p class="empty-state">Aucun témoignage ajouté pour le moment</p>';
    return;
  }

  container.innerHTML = temoignages.map(temoignage => `
    <div class="item-card">
      <div class="item-content">
        <h3>${escapeHtml(temoignage.auteur)}</h3>
        <p>${escapeHtml(temoignage.texte)}</p>
      </div>
      <div class="item-actions">
        <button class="btn btn-danger btn-small" onclick="deleteTemoignage(${temoignage.id})">Supprimer</button>
      </div>
    </div>
  `).join('');
}

// Supprimer un projet
function deleteProjet(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
    const projets = JSON.parse(localStorage.getItem('projets') || '[]');
    const filtered = projets.filter(p => p.id !== id);
    localStorage.setItem('projets', JSON.stringify(filtered));
    displayProjets();
    updateStats();
    addActivity('Projet supprimé');
  }
}

// Supprimer une image de la galerie
function deleteGalerie(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
    const galerie = JSON.parse(localStorage.getItem('galerie') || '[]');
    const filtered = galerie.filter(i => i.id !== id);
    localStorage.setItem('galerie', JSON.stringify(filtered));
    displayGalerie();
    updateStats();
    addActivity('Image supprimée de la galerie');
  }
}

// Supprimer un bénévole
function deleteBenevole(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce bénévole ?')) {
    const benevoles = JSON.parse(localStorage.getItem('benevoles') || '[]');
    const filtered = benevoles.filter(b => b.id !== id);
    localStorage.setItem('benevoles', JSON.stringify(filtered));
    displayBenevoles();
    updateStats();
    addActivity('Bénévole supprimé');
  }
}

// Supprimer un témoignage
function deleteTemoignage(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')) {
    const temoignages = JSON.parse(localStorage.getItem('temoignages') || '[]');
    const filtered = temoignages.filter(t => t.id !== id);
    localStorage.setItem('temoignages', JSON.stringify(filtered));
    displayTemoignages();
    updateStats();
    addActivity('Témoignage supprimé');
  }
}

// Charger toutes les données
function loadAllData() {
  displayProjets();
  displayGalerie();
  displayBenevoles();
  displayTemoignages();
}

// Mettre à jour les statistiques
function updateStats() {
  const projets = JSON.parse(localStorage.getItem('projets') || '[]');
  const galerie = JSON.parse(localStorage.getItem('galerie') || '[]');
  const benevoles = JSON.parse(localStorage.getItem('benevoles') || '[]');
  const temoignages = JSON.parse(localStorage.getItem('temoignages') || '[]');

  document.getElementById('stat-projets').textContent = projets.length;
  document.getElementById('stat-galerie').textContent = galerie.length;
  document.getElementById('stat-benevoles').textContent = benevoles.length;
  document.getElementById('stat-temoignages').textContent = temoignages.length;
}

// Ajouter une activité
function addActivity(message) {
  const activities = JSON.parse(localStorage.getItem('activities') || '[]');
  activities.unshift({
    message: message,
    date: new Date().toISOString()
  });
  
  // Garder seulement les 10 dernières activités
  if (activities.length > 10) {
    activities.pop();
  }
  
  localStorage.setItem('activities', JSON.stringify(activities));
  displayActivities();
}

// Afficher les activités
function displayActivities() {
  const container = document.getElementById('recent-activities');
  const activities = JSON.parse(localStorage.getItem('activities') || '[]');
  
  if (activities.length === 0) {
    container.innerHTML = '<p class="empty-state">Aucune activité récente</p>';
    return;
  }

  container.innerHTML = activities.map(activity => {
    const date = new Date(activity.date);
    return `
      <div class="activity-item">
        <p>${escapeHtml(activity.message)}</p>
        <p class="activity-time">${date.toLocaleString('fr-FR')}</p>
      </div>
    `;
  }).join('');
}

// Exporter des données
function exportData(type) {
  const data = JSON.parse(localStorage.getItem(type) || '[]');
  const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `${type}-${new Date().toISOString().split('T')[0]}.json`;
  a.click();
  URL.revokeObjectURL(url);
}

// Exporter toutes les données
function exportAllData() {
  const allData = {
    projets: JSON.parse(localStorage.getItem('projets') || '[]'),
    galerie: JSON.parse(localStorage.getItem('galerie') || '[]'),
    benevoles: JSON.parse(localStorage.getItem('benevoles') || '[]'),
    temoignages: JSON.parse(localStorage.getItem('temoignages') || '[]'),
    settings: JSON.parse(localStorage.getItem('settings') || '{}')
  };
  
  const blob = new Blob([JSON.stringify(allData, null, 2)], { type: 'application/json' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `backup-${new Date().toISOString().split('T')[0]}.json`;
  a.click();
  URL.revokeObjectURL(url);
}

// Échapper le HTML pour éviter les injections
function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Configuration de l'API Laravel
// IMPORTANT: Modifiez cette URL selon votre configuration Laravel
// Exemples:
// - Développement local: 'http://localhost:8000/api'
// - Production: 'https://votre-domaine.com/api'
const API_BASE_URL = 'http://localhost:8000/api';

// Charger les messages depuis l'API


// Afficher les messages dans le tableau
function displayMessages(messages) {
  const tbody = document.getElementById('messages-table-body');
  if (!tbody) return;

  if (messages.length === 0) {
    tbody.innerHTML = '<tr><td colspan="8" class="empty-state-table">Aucun message reçu</td></tr>';
    return;
  }

  tbody.innerHTML = messages.map(message => `
    <tr>
      <td>#${message.id}</td>
      <td>${escapeHtml(message.nom || '')}</td>
      <td>${escapeHtml(message.prenom || '')}</td>
      <td>${escapeHtml(message.email || '')}</td>
      <td>${escapeHtml(message.objet || '')}</td>
      <td class="message-preview" title="${escapeHtml(message.message || '')}">${escapeHtml((message.message || '').substring(0, 50))}${(message.message || '').length > 50 ? '...' : ''}</td>
      <td>${formatDate(message.created_at || message.date)}</td>
      <td class="table-actions">
        <button class="btn btn-view btn-small" onclick="viewMessage(${message.id})">Voir</button>
        <button class="btn btn-danger btn-small" onclick="deleteMessage(${message.id})">Supprimer</button>
      </td>
    </tr>
  `).join('');
}

// Charger les candidatures depuis l'API
async function loadCandidatures() {
  const tbody = document.getElementById('candidatures-table-body');
  if (!tbody) return;

  tbody.innerHTML = '<tr><td colspan="9" class="loading-state">Chargement des candidatures...</td></tr>';

  try {
    const response = await fetch(`${API_BASE_URL}/candidatures`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Erreur lors du chargement des candidatures');
    }

    const candidatures = await response.json();
    displayCandidatures(candidatures.data || candidatures);
  } catch (error) {
    console.error('Erreur:', error);
    tbody.innerHTML = `<tr><td colspan="9" class="empty-state-table">Erreur de chargement. Vérifiez votre connexion à l'API Laravel.</td></tr>`;
  }
}

// Afficher les candidatures dans le tableau
function displayCandidatures(candidatures) {
  const tbody = document.getElementById('candidatures-table-body');
  if (!tbody) return;

  if (candidatures.length === 0) {
    tbody.innerHTML = '<tr><td colspan="9" class="empty-state-table">Aucune candidature reçue</td></tr>';
    return;
  }

  // Stocker les candidatures pour le filtrage
  window.candidaturesData = candidatures;

  tbody.innerHTML = candidatures.map(candidature => `
    <tr>
      <td>#${candidature.id}</td>
      <td>${escapeHtml(candidature.nom || '')}</td>
      <td>${escapeHtml(candidature.prenom || '')}</td>
      <td>${escapeHtml(candidature.email || '')}</td>
      <td>${escapeHtml(candidature.telephone || '')}</td>
      <td><span class="badge badge-${candidature.typeParticipation || 'default'}">${escapeHtml(formatTypeParticipation(candidature.typeParticipation || ''))}</span></td>
      <td>${escapeHtml(formatPreference(candidature.preferenceAction || ''))}</td>
      <td>${formatDate(candidature.created_at || candidature.date)}</td>
      <td class="table-actions">
        <button class="btn btn-view btn-small" onclick="viewCandidature(${candidature.id})">Voir</button>
        <button class="btn btn-danger btn-small" onclick="deleteCandidature(${candidature.id})">Supprimer</button>
      </td>
    </tr>
  `).join('');
}

// Voir les détails d'un message
async function viewMessage(id) {
  try {
    const response = await fetch(`${API_BASE_URL}/messages/${id}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Erreur lors du chargement du message');
    }

    const message = await response.json();
    const data = message.data || message;

    const modal = document.getElementById('message-detail-modal');
    const content = document.getElementById('message-detail-content');

    content.innerHTML = `
      <div class="detail-group">
        <div class="detail-label">Nom</div>
        <div class="detail-value">${escapeHtml(data.nom || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Prénom</div>
        <div class="detail-value">${escapeHtml(data.prenom || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Email</div>
        <div class="detail-value">${escapeHtml(data.email || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Objet</div>
        <div class="detail-value">${escapeHtml(data.objet || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Message</div>
        <div class="detail-value text-area">${escapeHtml(data.message || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Date</div>
        <div class="detail-value">${formatDate(data.created_at || data.date)}</div>
      </div>
    `;

    modal.classList.add('active');
  } catch (error) {
    console.error('Erreur:', error);
    alert('Erreur lors du chargement du message');
  }
}

// Voir les détails d'une candidature
async function viewCandidature(id) {
  try {
    const response = await fetch(`${API_BASE_URL}/candidatures/${id}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Erreur lors du chargement de la candidature');
    }

    const candidature = await response.json();
    const data = candidature.data || candidature;

    const modal = document.getElementById('candidature-detail-modal');
    const content = document.getElementById('candidature-detail-content');

    content.innerHTML = `
      <div class="detail-group">
        <div class="detail-label">Nom</div>
        <div class="detail-value">${escapeHtml(data.nom || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Prénom</div>
        <div class="detail-value">${escapeHtml(data.prenom || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Date de naissance</div>
        <div class="detail-value">${escapeHtml(data.dateNaissance || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Email</div>
        <div class="detail-value">${escapeHtml(data.email || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Téléphone</div>
        <div class="detail-value">${escapeHtml(data.telephone || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Adresse</div>
        <div class="detail-value">${escapeHtml(data.adresse || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Type de participation</div>
        <div class="detail-value">${escapeHtml(formatTypeParticipation(data.typeParticipation || ''))}${data.autreType ? ` - ${escapeHtml(data.autreType)}` : ''}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Disponibilités</div>
        <div class="detail-value text-area">${escapeHtml(data.disponibilites || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Préférence d'action</div>
        <div class="detail-value">${escapeHtml(formatPreference(data.preferenceAction || ''))}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Lettre de motivation</div>
        <div class="detail-value text-area">${escapeHtml(data.motivation || '')}</div>
      </div>
      <div class="detail-group">
        <div class="detail-label">Date de candidature</div>
        <div class="detail-value">${formatDate(data.created_at || data.date)}</div>
      </div>
    `;

    modal.classList.add('active');
  } catch (error) {
    console.error('Erreur:', error);
    alert('Erreur lors du chargement de la candidature');
  }
}

// Supprimer un message
async function deleteMessage(id) {
  if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/messages/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Erreur lors de la suppression');
    }

    loadMessages();
    addActivity('Message supprimé');
    alert('Message supprimé avec succès !');
  } catch (error) {
    console.error('Erreur:', error);
    alert('Erreur lors de la suppression du message');
  }
}

// Supprimer une candidature
async function deleteCandidature(id) {
  if (!confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')) {
    return;
  }

  try {
    const response = await fetch(`${API_BASE_URL}/candidatures/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Erreur lors de la suppression');
    }

    loadCandidatures();
    addActivity('Candidature supprimée');
    alert('Candidature supprimée avec succès !');
  } catch (error) {
    console.error('Erreur:', error);
    alert('Erreur lors de la suppression de la candidature');
  }
}

// Filtrer les messages
function filterMessages() {
  const search = document.getElementById('messages-search').value.toLowerCase();
  const rows = document.querySelectorAll('#messages-table-body tr');

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(search) ? '' : 'none';
  });
}

// Filtrer les candidatures
function filterCandidatures() {
  const search = document.getElementById('candidatures-search').value.toLowerCase();
  const filter = document.getElementById('candidatures-filter').value;
  const rows = document.querySelectorAll('#candidatures-table-body tr');

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const typeMatch = !filter || row.textContent.includes(filter);
    const searchMatch = !search || text.includes(search);
    row.style.display = (typeMatch && searchMatch) ? '' : 'none';
  });
}

// Configuration des modals
function setupModals() {
  const modals = document.querySelectorAll('.modal');
  const closeButtons = document.querySelectorAll('.modal-close');

  closeButtons.forEach(button => {
    button.addEventListener('click', function() {
      this.closest('.modal').classList.remove('active');
    });
  });

  modals.forEach(modal => {
    modal.addEventListener('click', function(e) {
      if (e.target === this) {
        this.classList.remove('active');
      }
    });
  });
}

// Formater la date
function formatDate(dateString) {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
}

// Formater le type de participation
function formatTypeParticipation(type) {
  const types = {
    'stagiaire': 'Stagiaire',
    'benevole': 'Bénévole',
    'autre': 'Autre'
  };
  return types[type] || type;
}

// Formater la préférence d'action
function formatPreference(pref) {
  const prefs = {
    'locale': 'Locale',
    'nationale': 'Nationale',
    'internationale': 'Internationale'
  };
  return prefs[pref] || pref;
}

// Afficher les activités au chargement
document.addEventListener('DOMContentLoaded', function() {
  displayActivities();
});
document.addEventListener('DOMContentLoaded', function() {
    // Rafraîchir la page
    const refreshBtn = document.getElementById('refresh-messages');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            location.reload();
        });
    }

    // Filtrer les messages
    const searchInput = document.getElementById('messages-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#messages-table-body tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});

