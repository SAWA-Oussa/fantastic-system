# AFRI-SCHOOL — Version commerciale étendue

**Éditeur : AFRICA DIGITAL SOLUTIONS**  
**Produit : AFRI-SCHOOL**

Application SaaS multi-établissements construite en PHP natif, MySQL/MariaDB, PDO, HTML/CSS et JavaScript natifs. Aucun framework PHP requis. Interface française responsive.

## Modèle commercial hybride (mise à jour)

AFRI-SCHOOL est exploité par AFRICA DIGITAL SOLUTIONS. La plateforme héberge deux types d'espaces :
- **Partenaire** : un établissement s'inscrit publiquement via `public/register-school.php`. La demande est contrôlée par le propriétaire plateforme. Après approbation, un espace partenaire est créé, un administrateur reçoit un lien d'activation valable 48 heures et un abonnement mensuel ou annuel est créé en attente de paiement. Le propriétaire confirme le paiement avant d'activer l'espace.
- **Academy** : AFRI-SCHOOL Academy est un établissement interne, de type `academy` (créé automatiquement à l’installation neuve, ou depuis Administration générale → AFRI-SCHOOL Academy après mise à jour). Son administrateur configure les programmes et enseignants. Les candidats déposent un dossier via `public/academy.php`; le service des admissions examine le dossier, prononce l'admission, puis enregistre et vérifie manuellement le paiement avant de créer le compte étudiant et l'inscription.

Les établissements partenaires encaissent directement leurs propres étudiants. Les paiements de leurs étudiants restent dans leur comptabilité et ne sont pas des revenus AFRICA DIGITAL SOLUTIONS. Les recettes de l'entreprise sont les abonnements SaaS; les recettes Academy sont gérées dans l'espace interne Academy. Ces flux doivent être rapprochés séparément en comptabilité. Les confirmations de paiement ajoutées dans cette version sont manuelles; aucun prélèvement récurrent automatique ni compte marchand n'est activé par défaut.

## Modules livrés dans cette édition

- Portail propriétaire de plateforme : établissements, abonnements SaaS, statistiques globales, intégrations et journal d’audit.
- Portail établissement : utilisateurs et rôles, admissions, programmes de 18 mois, inscriptions, cours, examens, notes, devoirs, paiements, ressources, emploi du temps, présences, notifications, événements, bourses, entreprises, stages, jury, certificats et paramètres.
- Portail enseignant : cours affectés, évaluations, notes, devoirs, corrections, présences, ressources, calendrier, notifications et messagerie.
- Portail étudiant : cours inscrits, devoirs, notes, relevé imprimable, bibliothèque, présences, notifications, choix d’entreprise pour le stage et dépôt du rapport PDF, portfolio, bourses, événements, carrière, tuteur IA, mentorat, incubateur et demandes.
- Portail parent : enfants associés, résultats, paiements, emploi du temps, assiduité, notifications, préférence WhatsApp avec consentement explicite et messagerie. Les données affichées sont filtrées par association parent-enfant.
- Portail entreprise : offres professionnelles, candidatures et suivi des stages affectés à l’entreprise.
- Documents : relevé imprimable en PDF via le navigateur, lettre de stage imprimable, certificat imprimable et page publique de vérification.
- Parcours : Niveau 1 mois 1–6, Niveau 2 mois 7–12, Niveau 3 mois 13–18. La délivrance du certificat est bloquée tant que les contrôles de parcours, moyenne, matières, stage vérifié et jury favorable ne sont pas satisfaits.

## Sécurité intégrée

- Mots de passe hachés avec `password_hash()` / `password_verify()`.
- Sessions durcies, cookies HttpOnly/SameSite, rotation d’identifiant à la connexion et expiration d’inactivité.
- Protection CSRF sur les formulaires POST.
- Limitation des tentatives de connexion par empreintes d’e-mail et d’adresse IP.
- Contrôles de rôles côté serveur.
- Requêtes PDO préparées.
- Filtrage `tenant_id` dans les opérations et contrôles de propriété des identifiants.
- Fichiers privés stockés hors du dossier public, noms aléatoires, validation MIME et limite de taille.
- Journal d’audit des opérations importantes.
- Secrets API non réaffichés dans les formulaires.
- Webhook de paiement générique signé HMAC et idempotent. Il doit être adapté au format de signature exact du fournisseur choisi.

## Installation neuve

1. Hébergement Apache/Nginx avec PHP 8.2+ et MySQL 8 ou MariaDB compatible. Extensions PHP requises : PDO MySQL, cURL, OpenSSL, mbstring, fileinfo.
2. Créer une base MySQL vide depuis le panneau d’hébergement.
3. Importer `database/schema.sql` dans cette base. Le fichier ne crée pas la base et ne contient pas de commande `USE`.
4. Copier `config.example.php` en `config.php` à la racine du projet, hors du DocumentRoot, puis renseigner les identifiants de base et `base_url`.
5. Idéalement, configurer le DocumentRoot sur `public/`. Sinon, conserver les protections `.htaccess` et vérifier que `app/`, `database/`, `storage/` et `config.php` ne sont pas accessibles publiquement.
6. Donner au processus PHP le droit d’écriture sur `storage/private/`.
7. Ouvrir `/install.php`. Le premier tenant créé est AFRI-SCHOOL Academy (tenant de type `academy`), avec le propriétaire plateforme et son administrateur Academy.
8. Supprimer immédiatement `public/install.php` après installation.
9. Publier `register-school.php` pour les établissements partenaires et `academy.php` pour les candidatures directes à l’Academy.
10. Activer HTTPS, configurer les intégrations nécessaires, les sauvegardes et la supervision.

## Mise à jour d'une installation précédente

Pour conserver les données de la base déjà utilisée :

1. Faire une sauvegarde complète de la base, de `config.php` et du stockage privé.
2. Déployer les nouveaux fichiers en conservant `config.php` et `storage/`.
3. Si la base provient de `AFRI_SCHOOL_SAAS_RELEASE_CANDIDATE.zip`, importer **une seule fois** `database/upgrade_from_release_candidate.sql`.
4. Si la base provient de `AFRI_SCHOOL_EDITION_COMMERCIALE_COMPLETE.zip`, importer **une seule fois** `database/upgrade_from_previous.sql`.
5. Importer ensuite **une seule fois** `database/upgrade_hybrid_model.sql`. Cette migration ajoute le modèle partenaire/Academy, les demandes d’établissement, les candidatures Academy, les invitations et la facturation annuelle.
6. Ne réimportez jamais `schema.sql` sur une base déjà initialisée.
7. Depuis Administration générale → AFRI-SCHOOL Academy, créer l’établissement interne Academy si aucun tenant de type `academy` n'existe.
8. Exécuter `php scripts/preflight.php` sur le serveur, puis réaliser les tests de recette avec des comptes de chaque rôle.

## Configuration des fournisseurs externes

Les emplacements de configuration sont prévus pour e-mail HTTP, WhatsApp Cloud API, SMS, passerelle de paiement, IA compatible OpenAI, visioconférence et stockage S3 compatible. Les clés ne sont pas incluses. Le tuteur IA et le webhook de paiement utilisent des adaptateurs génériques. Les paiements réels, notifications, signatures, formats de webhook, comptes marchands et services vidéo nécessitent les comptes et spécifications du fournisseur choisi. La gestion d’abonnements SaaS est présente ; le prélèvement récurrent automatique doit être connecté au fournisseur de facturation choisi. Le module d’insertion permet le suivi des engagements, mais ne crée pas à lui seul une garantie d’emploi ou un droit automatique au remboursement. Le paiement manuel reste en attente jusqu’à confirmation explicite ou webhook signé.

## Important — exploitation commerciale

Le paquet est une livraison logicielle avancée, avec code source, schéma complet et mécanismes de sécurité. Les vérifications de syntaxe PHP peuvent être exécutées localement. Le script `php scripts/preflight.php` contrôle les extensions, les tables SQL et les permissions de stockage sur le serveur configuré. L’environnement de génération ne dispose pas d’un serveur MySQL/MariaDB pour réaliser ici une recette de bout en bout. Avant d’importer des données personnelles réelles, faire la recette fonctionnelle sur l’hébergement cible, tester les sauvegardes/restaurations et faire réaliser un audit indépendant. Les règles juridiques relatives aux données personnelles, aux certificats, aux remboursements et à la garantie d’emploi doivent être validées pays par pays.
