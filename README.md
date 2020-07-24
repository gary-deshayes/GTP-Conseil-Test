# Test d'entrée GTP Conseil

Projet sous Symfony 5.1

## Prérequis du projet
- PHP 7.2.5 minimum
- MySQL 5.7
- /!\ Internet pour les CDNs
- Composer (dépendance PHP)
- NPM (dépendance JS)

##Récupérer les dépendances PHP
Lancer la commande 'composer install' avec l'outil composer

## Récupérer les dépendance JS
Lancer la commance 'npm install' avec l'outil NPM

## Lancer le projet

###Initialiser la base de données 
Lancer la commande php bin/console 'doctrine:database:create' ou d:d:c pour créer la base de données

###Construire le schéma de la base de données grâce aux migrations
Lancer la commance php bin/console 'doctrine:migrations:migrate' ou d:m :m

###Initialiser les fausses données grâce aux fixtures 
Lancer la commance 'php bin/console doctrine:fixtures:load' ou d:f:l et accepter avec 'yes'

Suite à cela votre base de données sera prête

## Connexion aux interfaces

Il y a plusieurs comptes auto-générés ainsi que 50 tâches:
admin : gtp@admin.fr mdp: azerty
employe: gtp@employe.fr mdp azerty

Et voilà vous accédez à cette superbe application.
