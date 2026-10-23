# Évolution de l’administration VEF

## Audit et choix

Le site utilise Laravel 12, Blade, Tailwind et Alpine. L’administration existante utilise Inter, un dégradé #2563eb / #1e40af, des cartes blanches, des boutons arrondis et une navigation latérale. Les modules équipe, témoignages, messages et candidatures sont conservés. Les projets existants et leurs galeries sont étendus dans les mêmes tables. Les pages d’édition réutilisent les styles et la navigation de cette administration ; aucun second système d’authentification ni CMS n’est introduit.

Les opérations utilisent les routes web Laravel, les sessions et CSRF. Aucune API indépendante n’est nécessaire. Les nouvelles pages publiques utilisent les mêmes modèles Eloquent que l’Admin.

## Installation

1. Sauvegarder la base avant la migration, selon la procédure de déploiement habituelle.
2. Exécuter `php artisan migrate --force`.
3. Attribuer le rôle au compte responsable existant : `php artisan admin:grant adresse@example.org`.
4. Compiler les styles : `npm run build` (Node 20.19+ ou 22.12+ recommandé par Vite).

Aucun utilisateur ne devient administrateur automatiquement. Le rôle `is_admin` est absent des champs assignables depuis l’inscription et le profil. Tous les comptes ordinaires sont refusés côté serveur. Les anciens projets publics restent publiés lors de la migration et reçoivent un slug stable ; leurs anciennes images principales rejoignent la galerie si nécessaire. Aucun contenu de démonstration n’est ajouté.

## Utilisation

- **Projets** : ouvrir « Créer un projet » ou « Modifier ». Les sections facultatives vides sont masquées sur le site. Les champs structurés utilisent une entrée par ligne avec `|` comme séparateur ; leurs formats sont expliqués dans le formulaire.
- Choisir une image principale parmi les photos de la galerie. Les imports sont limités aux JPEG, PNG et WebP de 3 Mo, avec des noms générés côté serveur.
- Enregistrer puis prévisualiser la version enregistrée. Passer la visibilité à « Publié » pour la rendre publique ; « Brouillon » la retire du site. « Archivé » conserve le dossier dans l’Admin, sans page publique. Le statut « Réalisé » permet de conserver une page publique pour un projet terminé.
- Les slugs restent identiques quand le titre change. Leur modification explicite change l’URL : conserver le slug pour les liens déjà partagés.
- **Actualités** : gérer les catégories, écrire l’article, associer plusieurs projets et publier. Le contenu accepte `## Titre`, `### Sous-titre` et `[texte](/chemin-interne)`. Le HTML n’est jamais exécuté.
- Les articles publiés apparaissent dans les actualités, l’accueil et les pages des projets associés. Aucun déploiement n’est nécessaire pour les modifications éditoriales.
- Le sitemap dynamique se trouve à `/sitemap.xml`. Les projets et articles non publiés sont exclus ; les aperçus sont protégés et marqués noindex.

## Paiements Stripe

La passerelle Stripe / Cashier existante est conservée pour les dons ponctuels, avec ou sans compte. Configurer `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET` et l’URL HTTPS publique `APP_URL`. Configurer le webhook Stripe vers `/stripe/webhook` avec les événements :

- `checkout.session.completed`
- `checkout.session.async_payment_succeeded`
- `checkout.session.async_payment_failed`
- `checkout.session.expired`

Les secrets restent dans l’environnement, jamais dans le code ou les pages publiques. La clé secrète Stripe permet d’ouvrir le paiement. Le secret de webhook est nécessaire pour confirmer et comptabiliser automatiquement les dons ; son absence ne bloque pas l’ouverture de Stripe. La seule exception CSRF est le webhook, qui vérifie la signature Stripe, le montant, la devise et la référence/session de transaction. Le traitement est transactionnel et idempotent. La page de retour ne confirme jamais un paiement.

L’Admin affiche les transactions en attente, confirmées, échouées ou expirées et les collectes par projet. Les totaux reposent sur les dons confirmés localement. Les données personnelles des donateurs ne sont pas stockées par ce module ni exposées publiquement. Les rapprochements historiques et remboursements effectués dans Stripe ne sont pas importés automatiquement : les collectes représentent les paiements confirmés reçus par ce module.

## Vérification

`php tests/Smoke/editorial.php` utilise exclusivement une base SQLite en mémoire : migrations, rendu public et Admin, refus des accès ordinaires, brouillons invisibles, création/publication, slugs stables, signature de webhook, idempotence, absence de confirmation par le navigateur et refus des suppressions anonymes.

La suite Pest existante nécessite une version PHP compatible avec ses dépendances installées ; elle ne démarre pas sous le PHP 8.2 de cet environnement. Le test d’intégration autonome fonctionne sous PHP 8.2. Les paiements réels et la livraison des webhooks Stripe doivent être vérifiés en environnement Stripe de test avant activation réelle. Aucun appel de paiement réel n’est effectué par les vérifications locales.

## Affichage euros / FCFA

Les boutons et l’espace de don du projet sont affichés uniquement si ses dons sont activés dans l’Admin.

Les budgets et collectes publics affichent aussi leur équivalent FCFA (XOF). Le formulaire accepte un montant libre en euros ou en FCFA ; la conversion côté serveur utilise la parité BCEAO de 1 EUR = 655,957 XOF, puis arrondit au centime d’euro pour le paiement Stripe. Le montant converti est affiché avant soumission. Les FCFA affichés sont arrondis au franc ; la banque peut appliquer ses propres frais. Source : https://www.bceao.int/cours/cours-des-devises-contre-Franc-CFA-appliquer-au-change-manuel
