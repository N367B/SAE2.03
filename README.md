# SAÉ 2.03 - [Dépôt GitHub](https://github.com/n367b/SAE2.03)

Reproduction d'un [r/place](https://www.reddit.com/r/place/) simplifié avec PHP et JavaScript.

>***Commentaires dans le code pour améliorer la compréhension.***

## **Comment utiliser le site**

*Prérequis :*

- Installer `php7.X`, `sqlite3` et `php7.X-sqlite3`
  > Avec $X \in \N$ et $X \le 4 $

Dans le répertoire où sont stockés les fichiers:
> `php -S localhost:50000`

## **Fichiers**

- `bdd.sqlite`
  - Base de données SQLite
- `choix.js`
  - Fonctions JavaScript pour l'interactivité
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
  - Utilisateurs les plus actifs

## **Fonctionnement**

Il y a deux pages principales : la page d'accueil et la page d'actions.
La page d'accueil est accessible depuis l'URL `http://localhost:50000/index.php`. Elle permet de se connecter ou de s'inscrire.

La page d'actions est accessible depuis l'URL `http://localhost:50000/place.php`. Elle permet d'afficher le canevas et de colorer un pixel.

*Base de donnée SQLite :*

Il y a deux tables : `Utilisateur` et `Pixel`.
 - `Utilisateur` :
   - `id_utilisateur` : Identifiant de l'utilisateur
   - `nom_utilisateur` : Nom de l'utilisateur
   - `mot_de_passe` : Mot de passe de l'utilisateur
   - `heure_dernier_pixel` : Heure de la dernière action de l'utilisateur
   - `nb_pixels` : Nombre de pixels colorés par un utilisateur
 - `Pixel` :
   - `coordonne_x` : Coordonnée x du pixel
   - `coordonne_y` : Coordonnée y du pixel
   - `id_utilisateur` : Identifiant de l'utilisateur ayant coloré le pixel
   - `couleur` : Couleur du pixel


### **init.php**

Page permettant d'initialiser la base de données et de supprimer celle existante.
 - Création de la table `Utilisateur` et d'un utilisateur `admin` d'ID=1
 - Création de la table `Pixel`, remplis le tableau 16 par 16 de pixels blanc

Pour intialiser la base de données, il faut se connecter en tant qu'administrateur (admin:admin), cliquer sur le bouton `Réinitialisation` puis valider en écrivant "oui".

### **index.php**

Page de connexion et d'inscription avec un formulaire de connexion, d'inscription et un bouton `Statistiques`.

 - Formulaire pour la connexion et l'inscription
 - Si on se connecte :
    - On cherche dans la base de donnée un utilisateur avec le nom donnée et le hash md5 du mot de passe correspondant
       - Si il y a un résultat, la connexion est validée et redirection vers la page `place.php`
       - Si il n'y a pas de résultat, la connexion n'est pas validée, alors un message d'erreur est affiché.
 - Si on s'inscrit :
    - Vérification que le nom d'utilisateur ne possède pas d'espace et qu'il n'existe pas dans la base de données
       - Si c'est validé, alors création du l'utilisateur dans la base de données avec le hash de sont mot de passe en md5
       - Si ce n'est pas validé, affichage d'un message d'erreur

### **place.php**

Page principale, affichage et modification de la grille.

 - Vérification que la session existe :
    - Sinon redirection vers `index.php`
 - Affichage d'un message de bienvenue personnalisée en fonction du nom d'utilisateur
 - Si l'utilsateur est un admin :
   - Un boutton allant à la page de réinitialsation de la base de données
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


### **stats.php**

Affiche dans un tableau les utilisateurs dans l'ordre décroissant par rapport au nombre de pixels qu'ils ont posés. 
Cela nous permet de voir quels utilisateurs sont les plus actifs.

 - Création d'un tableau de deux colonnes
 - Récupération des utilisateurs et du nombre de pixels posés dans la base de données
 - Pour chaque resultat :
   - Verification que l'utilisateur n'est pas admin (id=1)
   - Verification que l'utilisateur à posé au moins un pixel
   - Affichage du nom de l'utilisateur dans la première colonne
   - Affichage du nombre de pixels dans la seconde colonne
 - Bouton de retour à la page d'accueil

### **choix.js**

Fonctions JavaScript permettant l'interactivité avec la page comme par exemple former la bordure et entrer automatiquement les coordonnées du pixel en cliquant dessus, envoyer un formulaire avec double clique et supprimer le style sur tout les pixels quand on clique dessus pour n'avoir une bordure que sur le pixel sur lequel on vient de cliquer.

- evenements()
  - Stocke tout les rectangles dans une variable t
  - Ajout d'un eventListener(dblclick) sur tout les éléments de t grâce à une boucle

- recup(x,y)
  - Stocke tout les rectangles dans une variable t
  - Suppression du style de tout les éléments de t avec une boucle
  - Ajout d'une bordure sur le pixel séléctionné
  - Ajout des valeurs de x et y dans le formulaire dédié

- valider()
 - Soumet le formulaire dédié à la colorisation d'un pixel 
