# reseau-social-php-reseau_social_fatouma
reseau-social-php-reseau_social_fatouma_nicolas_thalia created by GitHub Classroom
# Nom du Projet de Blog en PHP

## Description

Ce projet de blog en PHP offre une plateforme simple et extensible pour la publication de contenus. Il utilise une base de données MySQL gérée via phpMyAdmin pour stocker les articles, les commentaires et d'autres informations liées au blog.

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


