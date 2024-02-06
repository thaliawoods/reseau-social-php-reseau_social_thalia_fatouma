# Réseau Social PHP


Ce projet de blog en PHP offre une plateforme simple et extensible pour la publication de contenus. Il utilise une base de données MySQL gérée via phpMyAdmin pour stocker les articles, les commentaires et d'autres informations liées au blog.


## Objectifs

• Faire un site web dynamique qui construit les pages HTML à la demande grâce à une base de donnée.
• Enrichir ce site de nouveaux contenus fournis par les utilisateurs avec des formulaires.
• Gérer les authentifications (login),sessions, autorisations (droits d’accès) et inscriptions.
• Avoir un premier aperçu de : la conception web, de la conception base de donnée, des problématiques d’un projet multi-langages.


## Groupe de 2 personnes - 6 jours

Fatouma F - Thalia WOODS 


## Fonctionnalités

- **Publication d'Articles :** Les utilisateurs peuvent créer, éditer et publier des articles sur le blog.

- **Gestion des Commentaires :** Les lecteurs peuvent laisser des commentaires sur les articles, et les auteurs peuvent modérer et répondre à ces commentaires.

- **Système d'Utilisateur :** Les auteurs peuvent créer un compte, se connecter et gérer leurs articles.

- **Gestion de la Base de Données :** Les données du blog, y compris les articles, les commentaires et les informations des utilisateurs, sont stockées dans une base de données MySQL gérée via phpMyAdmin.


## Installation


. Importez la structure de la base de données à l'aide du fichier SQL fourni dans le dossier `database`.

. Configurez les paramètres de connexion à la base de données dans le fichier `config.php`.


## Utilisation

1. Accédez à l'interface du blog via votre navigateur.

2. Créez un compte utilisateur ou utilisez les identifiants par défaut fournis dans le fichier `config.php`.

3. Commencez à publier des articles et à interagir avec les commentaires.
   

## Structure du Projet

- **`index.php` :** Point d'entrée du blog.

- **`admin/` :** Section d'administration pour la gestion des utilisateurs et des articles.

- **`includes/` :** Fichiers inclus, tels que des fonctions PHP réutilisables.

- **`database/` :** Scripts SQL pour la création de la base de données.


## Configuration de phpMyAdmin

1. Accédez à phpMyAdmin via votre navigateur.

2. Créez une nouvelle base de données et importez la structure à partir du fichier SQL fourni.

3. Mettez à jour les informations de connexion à la base de données dans le fichier `config.php`.


## Aperçu du projet

( mettre screen )


## Lancement du projet


