# Programmes de parrainage

## Périmètre

La page `/parrainage` présente deux programmes réels de l’association :

- **Enfant** : accompagnement individuel, contribution initiale de 25 € par mois pour la scolarité et les repas. L’équivalent FCFA utilise le service `Money` déjà présent.
- **Santé** : soutien mensuel, avec un montant libre.

Chaque bouton mène au contact existant. La mise en place du parrainage, les versements manuels et le suivi sont organisés ensuite avec l’association. Ce module ne crée aucun paiement, abonnement, compte de parrain ou dossier d’enfant.

## Administration

Depuis l’Admin existant, ouvrir **Parrainage** (`/administrateur/parrainage`). Pour chaque programme, il est possible de modifier le titre, l’accroche, la description et une photo facultative. Le montant mensuel du programme enfant est modifiable en euros ; le programme santé conserve un montant libre.

Les modifications enregistrées sont immédiatement utilisées par la page publique et son aperçu sur l’accueil. Les deux programmes sont créés par la migration `2026_10_24_000001_create_programmes_parrainage_table.php`. La migration est à appliquer lors du déploiement avec `php artisan migrate --force` ; elle n’altère pas les projets, utilisateurs ou transactions existants.

Les imports acceptent JPEG, PNG ou WebP, jusqu’à 3 Mo, avec une description obligatoire pour l’accessibilité. Les noms sont générés côté serveur. Les photos sont stockées dans `public/Style1/imagesParrainage`, exclu de Git ; prévoir sa sauvegarde et sa persistance sur l’hébergement comme pour les autres photos de l’Admin. Retirer une photo la retire de la présentation ; le fichier n’est pas supprimé automatiquement.

## Organisation du code

| Fichier | Rôle |
| --- | --- |
| `app/Models/ProgrammeParrainage.php` | Données des programmes et liens de contact. |
| `app/Http/Controllers/ParrainageController.php` | Page publique, formulaire Admin et enregistrement. |
| `app/Http/Requests/UpdateProgrammeParrainageRequest.php` | Autorisation administrateur et validation des champs/imports. |
| `resources/views/parrainage/index.blade.php` | Présentation, parcours et FAQ. |
| `resources/views/components/parrainage-programme.blade.php` | Carte réutilisable pour les deux programmes. |
| `resources/views/parrainage/teaser.blade.php` | Présentation courte sur l’accueil. |
| `resources/views/admin/parrainage.blade.php` | Formulaires dans l’interface Admin existante. |

Le lien vers le contact utilise uniquement le code stable du programme (`enfant` ou `sante`). `ControllerAccueil` retrouve le programme en base et prépare l’objet du message côté serveur ; une valeur inconnue ou mal formée est ignorée. Le visiteur peut modifier cet objet. En cas d’erreur de formulaire, ses saisies précédentes restent prioritaires.

Les demandes sont enregistrées dans la table `messages`, affichées dans le module existant et transmises par le mail de contact déjà en place. Aucun second canal de messagerie n’est créé. Le rôle `admin`, les sessions et la protection CSRF de Laravel sont réutilisés.

## Vérification

```bash
php tests/Smoke/parrainage.php
php tests/Smoke/editorial.php
npm run build
```

Le test de parrainage utilise une base SQLite exclusivement en mémoire et simule le mail. Il vérifie les montants initiaux, le préremplissage des deux parcours, l’enregistrement des demandes, les droits, la publication des modifications et les validations monétaires et des photos. Son fichier photo temporaire est supprimé en fin de test. Aucun mail réel ni paiement n’est effectué.

Le rendu a également été inspecté avec Chrome en formats ordinateur (1440 px) et mobile (390 px), à partir d’un aperçu local.
