# SAÉ 2.03

Reproduction d'un [r/place](https://www.reddit.com/r/place/) simplifie, en php et JavaScript

***Des commentaires dans le code source permettent de mieux comprendre le fonctionnement***
## Fichiers

- `bdd.sqlite`
  - Fichier de la base de donnée SQLite
- `choix.js`
  - fonction JavaScript pour le choix des pixels
- `favicon.ico`
  - icône du site
- `index.php`
  - page d'accueil
- `init.php`
  - initialisation du site
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

## Fonctionnement

Il y a deux pages principales : la page d'accueil et la page d'actions.
La page d'accueil est accessible depuis l'URL `http://localhost/SAE23/index.php`. Elle permet de se connecter ou de s'inscrire.
La page d'actions est accessible depuis l'URL `http://localhost/SAE23/place.php`. Elle d'afficher le canevas et permet de choisir un pixel.

Base de donnée SQLite :
Il y a deux tables : `utilisateurs` et `pixels`.
 - `utilisateurs` :
   - `id` : identifiant de l'utilisateur
 - `pixels` :
   - `x`


### Init.php

Page permettant d'initialiser la base de données, et de supprimer l'existante

### Index.php

Page de connexion et d'inscription, avec un formulaire de connexion et un formulaire d'inscription.

### Place.php

Page principale, affichage et modification de la grille.

## Comment utiliser le site sous GNU/Linux

Avec php7.4 d'installer et sqlite3/php7.4-sqlite3
Dans le répertoire, `php -S localhost:5000`


---

```JavaScript
// Initialisation de la grille
      <script type="text/javascript">
        let colors = ["#FFFFFF", "#E4E4E4", "#888888", "#222222", "#FFA7D1", "#E50000", "#E59500", "#A06A42", "#E5D900", "#94E044", "#02BE01", "#00D3DD", "#0083C7", "#0000EA", "#CF6EE4", "#820080"];
        let pixels = <?php echo json_encode($pixels); ?>;
        document.write('<svg viewBox="0 0 17 17" xmlns="http://www.w3.org/2000/svg" class="SVGgrid" width="700px">');
        for (var i = 0; i < 16; i++) {
          for (var j = 0; j < 16; j++) {
            document.write(`<rect x="${j}" y="${i}" width="1" height="1" fill="${pixels[i][j]}" id="${j}-${i}" onclick="recup(${j},${i})"/>`);
          }
        }
        document.write('</svg>');
      </script>
```
