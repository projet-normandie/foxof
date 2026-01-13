# Foxof - Liste de Jeux Terminés

Site web personnel du joueur Foxof qui recense l'ensemble de ses jeux terminés.

## Description

Cette application permet de consulter la liste complète des jeux vidéo terminés par Foxof, avec les informations suivantes :
- Nom du jeu
- Image de couverture
- Plateforme de jeu
- Date de complétion
- Nombre de fois que le jeu a été terminé

## Technologies

- Symfony 8
- PHP 8.4
- Doctrine ORM
- Twig
- Tailwind CSS (via Asset Mapper)

## Installation

```bash
# Installer les dépendances
composer install

# Configurer la base de données
cp .env .env.local
# Éditer .env.local avec vos paramètres de base de données

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Démarrer le serveur de développement
symfony serve
```

## Administration

Une interface d'administration permet de gérer les plateformes et les jeux terminés.