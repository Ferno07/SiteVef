<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administration - Verre d'eau fraîche</title>
  <link rel="icon" type="image/jpg" href="header/logo.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('Style1/css/admin.css') }}">
</head>
<body>
  <div class="admin-container">
    <!-- Sidebar Menu -->
    <aside class="admin-sidebar">
      <div class="sidebar-header">
        <h2>Administration</h2>
        <p>Verre d'eau fraîche</p>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li>
            <a href="#" class="nav-item active" data-panel="dashboard">
              <span class="nav-icon">📊</span>
              <span>Dashboard</span>
            </a>
          </li>

          <li>
            <a href="#" class="nav-item" data-panel="projets">
              <span class="nav-icon">📁</span>
              <span>Nos projets en cours</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="galerie">
              <span class="nav-icon">🖼️</span>
              <span>Galerie (Nos actions)</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="benevoles">
              <span class="nav-icon">👥</span>
              <span>Bénévoles</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="temoignages">
              <span class="nav-icon">💬</span>
              <span>Témoignages</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="messages">
              <span class="nav-icon">📧</span>
              <span>Messages reçus</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="candidatures">
              <span class="nav-icon">📝</span>
              <span>Candidatures</span>
            </a>
          </li>
          <li>
            <a href="#" class="nav-item" data-panel="settings">
              <span class="nav-icon">⚙️</span>
              <span>Paramètres</span>
            </a>
          </li>
        </ul>
      </nav>
      <div class="sidebar-footer">
        <a href="index.html" class="back-link">← Retour au site</a>
      </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
      <!-- Dashboard Panel -->
      <div class="admin-panel active" id="dashboard">
        <div class="panel-header">
          <h1>Dashboard</h1>
          <p>Vue d'ensemble de votre administration</p>
        </div>
        <div class="dashboard-stats">
          <div class="stat-card">
            <h3>Projets en cours</h3>
            <p class="stat-number" id="stat-projets">0</p>
          </div>
          <div class="stat-card">
            <h3>Images galerie</h3>
            <p class="stat-number" id="stat-galerie">0</p>
          </div>
          <div class="stat-card">
            <h3>Bénévoles</h3>
            <p class="stat-number" id="stat-benevoles">0</p>
          </div>
          <div class="stat-card">
            <h3>Témoignages</h3>
            <p class="stat-number" id="stat-temoignages">0</p>
          </div>
        </div>
        <div class="dashboard-recent">
          <h2>Activités récentes</h2>
          <div id="recent-activities" class="activities-list">
            <p class="empty-state">Aucune activité récente</p>
          </div>
        </div>
      </div>

      <!-- Projets Panel -->
      <div class="admin-panel" id="projets">
        <div class="panel-header">
          <h1>Nos projets en cours</h1>
          <p>Gérer les projets de l'association</p>
        </div>
        <div class="panel-content">
          <div class="form-section">
            <h2>Ajouter un nouveau projet</h2>
            <form method="POST" action="{{ route('admin.projets.enregistrer') }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="projet-titre">Titre du projet <span class="required">*</span></label>
                <input type="text" id="projet-titre" name="titre" required placeholder="Ex: Construction d'une école">
              </div>
              <div class="form-group">
                <label for="projet-description">Description courte</label>
                <input type="text" id="projet-description" name="description" placeholder="Une description courte du projet">
              </div>
              <div class="form-group">
                <label for="projet-description-longue">Description détaillée</label>
                <textarea id="projet-description-longue" name="description_longue" rows="5" placeholder="Description complète du projet..."></textarea>
              </div>
              <div class="form-group">
                <label for="projet-image">Image du projet</label>
                <input type="file" id="projet-image" name="image" accept="image/*">
                <div class="image-preview" id="projet-image-preview"></div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ajouter le projet</button>
                <button type="reset" class="btn btn-secondary">Réinitialiser</button>
              </div>
            </form>
          </div>
         <div class="list-section">
    <h2>Projets existants</h2>

    @if($projets->isEmpty())
        <p>Aucun projet pour le moment.</p>
    @else
        <div class="existing-projects">
            @foreach($projets as $projet)
                <div class="project-item">
                    <img 
    src="{{ asset($projet->image) }}" 
    alt="{{ $projet->titre }}" 
    class="project-thumb"
    style="width: 120px; height: 80px; object-fit: cover;"
>

                    <div class="project-info">
                        <h3>{{ $projet->titre }}</h3>
                        <p>{{ $projet->description }}</p>
                        <p>{{ $projet->description_longue }}</p>

                        <form action="{{ route('posts.destroy', $projet->id) }}" method="POST" class="inline">
                      @csrf
                      @method('DELETE')
                      <button onclick="return confirm('Supprimer cet élément ?')" class="text-red-500">
                           Supprimer
                      </button>
                  </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

      </div>
      </div>

      <!-- Galerie Panel -->
      <div class="admin-panel" id="galerie">
        <div class="panel-header">
          <h1>Galerie (Nos actions)</h1>
          <p>Gérer les images de la galerie</p>
        </div>
        <div class="panel-content">
          <div class="form-section">
            <h2>Ajouter une nouvelle image</h2>
            <form id="galerie-form" class="admin-form">
              <div class="form-group">
                <label for="galerie-image">Image <span class="required">*</span></label>
                <input type="file" id="galerie-image" name="image" accept="image/*" required>
                <div class="image-preview" id="galerie-image-preview"></div>
              </div>
              <div class="form-group">
                <label for="galerie-texte">Texte à afficher sur l'image</label>
                <input type="text" id="galerie-texte" name="texte" placeholder="Ex: Accès à l'éducation pour tous les enfants">
              </div>
              <div class="form-group">
                <label for="galerie-position">Position dans la grille</label>
                <select id="galerie-position" name="position">
                  <option value="top-left">Haut gauche</option>
                  <option value="top-right">Haut droite</option>
                  <option value="bottom-left">Bas gauche</option>
                  <option value="bottom-right">Bas droite</option>
                </select>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ajouter l'image</button>
                <button type="reset" class="btn btn-secondary">Réinitialiser</button>
              </div>
            </form>
          </div>
          <div class="list-section">
            <h2>Images existantes</h2>
            <div id="galerie-list" class="items-list gallery-grid-admin">
              <p class="empty-state">Aucune image ajoutée pour le moment</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Bénévoles Panel -->
      <div class="admin-panel" id="benevoles">
        <div class="panel-header">
          <h1>Bénévoles</h1>
          <p>Gérer les informations des bénévoles</p>
        </div>
        <div class="panel-content">
          <div class="form-section">
            <h2>Ajouter un bénévole</h2>
            <form id="benevole-form" class="admin-form">
              <div class="form-group">
                <label for="benevole-nom">Nom <span class="required">*</span></label>
                <input type="text" id="benevole-nom" name="nom" required>
              </div>
              <div class="form-group">
                <label for="benevole-role">Rôle</label>
                <input type="text" id="benevole-role" name="role" placeholder="Ex: Coordinateur">
              </div>
              <div class="form-group">
                <label for="benevole-image">Photo</label>
                <input type="file" id="benevole-image" name="image" accept="image/*">
                <div class="image-preview" id="benevole-image-preview"></div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ajouter le bénévole</button>
                <button type="reset" class="btn btn-secondary">Réinitialiser</button>
              </div>
            </form>
          </div>
          <div class="list-section">
            <h2>Bénévoles existants</h2>
            <div id="benevoles-list" class="items-list">
              <p class="empty-state">Aucun bénévole ajouté pour le moment</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Témoignages Panel -->
      <div class="admin-panel" id="temoignages">
        <div class="panel-header">
          <h1>Témoignages</h1>
          <p>Gérer les témoignages</p>
        </div>
        <div class="panel-content">
          <div class="form-section">
            <h2>Ajouter un témoignage</h2>
            <form id="temoignage-form" class="admin-form">
              <div class="form-group">
                <label for="temoignage-auteur">Auteur <span class="required">*</span></label>
                <input type="text" id="temoignage-auteur" name="auteur" required>
              </div>
              <div class="form-group">
                <label for="temoignage-texte">Témoignage <span class="required">*</span></label>
                <textarea id="temoignage-texte" name="texte" rows="5" required></textarea>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ajouter le témoignage</button>
                <button type="reset" class="btn btn-secondary">Réinitialiser</button>
              </div>
            </form>
          </div>
          <div class="list-section">
            <h2>Témoignages existants</h2>
            <div id="temoignages-list" class="items-list">
              <p class="empty-state">Aucun témoignage ajouté pour le moment</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Messages Panel -->
<!-- Messages Panel -->
<div class="admin-panel" id="messages">
    <div class="panel-header">
        <h1>Messages reçus</h1>
        <p>Gérer les messages du formulaire de contact</p>
    </div>

    <div class="panel-content-full">
        <div class="table-controls">
            <button class="btn btn-primary" id="refresh-messages">Actualiser</button>
            <div class="table-filters">
                <input type="text" id="messages-search" placeholder="Rechercher..." class="search-input">
            </div>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Objet</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="messages-table-body">
                    @forelse($messages as $message)
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->nom }}</td>
                            <td>{{ $message->prenom }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->objet }}</td>
                            <td>{{ $message->message }}</td>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            <p>Total messages : {{ $messages->count() }}</p>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="loading-state">Aucun message pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>




      <!-- Candidatures Panel -->
      <div class="admin-panel" id="candidatures">
        <div class="panel-header">
          <h1>Candidatures</h1>
          <p>Gérer les candidatures pour rejoindre l'association</p>
        </div>
        <div class="panel-content-full">
          <div class="table-controls">
            <button class="btn btn-primary" id="refresh-candidatures">Actualiser</button>
            <div class="table-filters">
              <input type="text" id="candidatures-search" placeholder="Rechercher..." class="search-input">
              <select id="candidatures-filter" class="filter-select">
                <option value="">Tous les types</option>
                <option value="stagiaire">Stagiaire</option>
                <option value="benevole">Bénévole</option>
                <option value="autre">Autre</option>
              </select>
            </div>
          </div>
          <div class="table-container">
            <table class="data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Type</th>
                  <th>Préférence</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="candidatures-table-body">
                <tr>
                  <td colspan="9" class="loading-state">Chargement des candidatures...</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="candidature-detail-modal" class="modal">
            <div class="modal-content">
              <span class="modal-close">&times;</span>
              <h2>Détails de la candidature</h2>
              <div id="candidature-detail-content"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings Panel -->
      <div class="admin-panel" id="settings">
        <div class="panel-header">
          <h1>Paramètres</h1>
          <p>Configuration générale</p>
        </div>
        <div class="panel-content">
          <div class="form-section">
            <h2>Paramètres du site</h2>
            <form id="settings-form" class="admin-form">
              <div class="form-group">
                <label for="site-titre">Titre du site</label>
                <input type="text" id="site-titre" name="titre" value="Verre d'eau fraîche">
              </div>
              <div class="form-group">
                <label for="site-description">Description</label>
                <textarea id="site-description" name="description" rows="3"></textarea>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer les paramètres</button>
              </div>
            </form>
          </div>
          <div class="form-section">
            <h2>Export des données</h2>
            <div class="export-buttons">
              <button class="btn btn-secondary" id="export-projets">Exporter les projets</button>
              <button class="btn btn-secondary" id="export-galerie">Exporter la galerie</button>
              <button class="btn btn-secondary" id="export-all">Exporter tout</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="{{ asset('Style1/js/admin.js') }}"></script>
</body>
</html>

