# SAÉ 2.03

Reproduction d'un [r/place](https://www.reddit.com/r/place/) simplifié avec PHP et JavaScript.

***Des commentaires dans le code source permettent de mieux comprendre le fonctionnement***

## Fichiers

- `bdd.sqlite`
  - Fichier de la base de données SQLite
- `choix.js`
  - Fonction JavaScript pour le choix des pixels et l'envoie de formulaires
- `favicon.ico`
  - Icône du site
- `index.php`
  - Page d'accueil
- `init.php`
  - Initialisation de la base de données du site
- `README.md`
  - Documentation du site
- `requetes.php`
  - Requêtes SQL
- `SAE23_cahier_des_charges.pdf`
  - Cahier des charges
- `styleIndex.css`
  - Style pour la page d'accueil
- `stylePlace.css`
  - Style pour la page place
- `stats.php`
  - Joueurs les plus actifs
## Fonctionnement

Il y a deux pages principales : la page d'accueil et la page d'actions.
La page d'accueil est accessible depuis l'URL `http://localhost:50000/index.php`. Elle permet de se connecter ou de s'inscrire.
La page d'actions est accessible depuis l'URL `http://localhost:50000/place.php`. Elle d'afficher le canevas et permet de choisir un pixel.

Base de donnée SQLite :
Il y a deux tables : `utilisateurs` et `pixels`.
 - `utilisateurs` :
   - `id` : identifiant de l'utilisateur
 - `pixels` :
   - `x`


### Init.php

Page permettant d'initialiser la base de données, et de supprimer l'existante
 - Création de la table Utilisateur, une un utilisateur admin d'id 1
 - Création de la table Pixel, remplie en 16*16 de pixels blanc

### Index.php

Page de connexion et d'inscription, avec un formulaire de connexion et un formulaire d'inscription.

 - Formulaire pour la connexion et l'inscription
 - Si on se connecte :
    - On cherche dans la base de donnée un utilisateur avec le nom donnée et le hash md5 correspondant
       - Si il y a un résultat, la connexion est validée et redirection vers la page `place.php`
       - Si il n'y a pas de résultat, la connexion n'est pas validée, alors un message d'erreur est affiché.
 - Si on s'inscrit :
    - Vérification que le nom d'utilisateur ne possède pas d'espace et qu'il n'existe pas dans la base de données
       - Si c'est validé, alors création du l'utilisateur dans la base de données avec le hash de sont mot de passe en md5
       - Si ce n'est pas validé, affichage d'un message d'erreur

### Place.php

Page principale, affichage et modification de la grille.

 - Vérification que la session existe :
    - Sinon redirection vers `index.php`
 - Affichage d'un message de bienvenue personnalisée en fonction du nom d'utilisateur
 - Récupération de la table Pixel dans depuis la base de données.
 - Création du tableau pixels (chaque couleurs et placé en fonction de ses coordonnées) :
    - Création d'un tableau vide (16*16)
    - Ajout des pixels dans le tableau
 - Appel du script JavaScript `choix.js`
 - Affichage du tableau de pixels en JavaScript :
   - Récupération des données depuis PHP
   - Affichage du SVG, en fonction des coordonnées et couleurs
 - Formulaire de placement des pixels (ligne / colonnes / couleur (en fonction du variable de SESSION)) - validation
   - Si le formulaire est envoyé :
     - On change la variable de SESSION par la couleur choisie
     - Vérification de l'heure du dernier pixel (plus de 60 secondes) ou que l'utilisateur est admin (id=1) :
      - Si c'est le cas :
         - Envoie du pixel dans la base de donnée (coordonnées, couleur et id d'utilisateur)
         - Modification date dernier pixel de l'utilisateur qui l'a posé
        - Rafraîchissement de la page
       - Sinon (il faut attendre encore) :
          - Désactivation du bouton de validation et changement de style
          - Affichage d'un timer en JavaScript en fonction du temps restant :
            - Si le temps est écoulé, on réactive le bouton de validation et on réaffiche la page
  - Fomulaire de déconnexion
    - Si le formulaire est envoyé :
      - On supprime la session
      - Redirection vers la page d'accueil


### stats.php

Affichage des statistiques, qui a posé le plus de pixels.



## Comment utiliser le site

Avec php7.4 d'installer et sqlite3/php7.4-sqlite3

Dans le répertoire, `php -S localhost:50000`
