# ApiV2
- Api commencer le 03/09/2020 pour restructurer mon code côter Api
- Les étapes de la mise en place du projet Symfony API sont là pour faire une base, pour débuter mais faut bien suivre les ressources mise à disposition pour faire un projet complet et qui marche.

# Installation des composants

Symfony : A la racine du répertoire installer son projet  (changer le my_project_name) :
-  composer create-project symfony/website-skeleton my_project_name
- cd/my_project_name

Api Platform : Faire l'installation d'Api Platform
- composer require api

Ensuite installer ces composants
- composer require orm
- composer require migrations
- composer --dev make

Ici c'est optionnel (moi j'ai installé mais pas fait la partie test)
- composer --dev make orm-fixtures : c'est pour remplir la db avec une boucle avec des données fake 
- composer --dev make test : c'est pour réalisée des test unitaire 
- composer require --dev fzaninotto/faker : c'est créer des données fake

Lexik Jwt, début des composants et des fichier à installer pour le token côtée API
Tout ce passe sur le terminal à la racine du projet
- composer require "lexik/jwt-authentication-bundle"
- mkdir -p config/jwt
- openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
- openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
Ici on céer : config/packages/lexik_jwt_authentication.yaml, le directory jwt et les fichiers private.pem et public.pem
,Pour la suite voir ressource car il y à la config à revoir pour le .env, config/packages/lexik_jwt_authentication.yaml, config/packages/security.yaml, config/routes.yaml.

Créer ces entités avec les relations (voir le dossier Entité pour ma part) et ne pas oubliés les migrations
 - Faire toute les commandes dans le terminal de l'IDE
 
 ## On à installer la base des composants et des fichiers pour commencer une API 
 ## Ressources:
 - https://symfony.com/doc/current/setup.html : pour créer le project Symfony
 - https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#getting-started : pour configurer l'ajout d'un token 
 - https://www.youtube.com/playlist?list=PLcfNN5yIpSA01Zfxxh9L3XsriAVHS2I-B : Youtuber qui fait une API du début à la fin en Symfony 


