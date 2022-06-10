function evenements() {
  /*
  Fonction qui gère les évènements, EventListener, pour le double clique.
*/
  let t = document.getElementsByTagName("rect"); // Récupération des rectangles.
  for (var i = 0; i < t.length; i++) {
    t[i].addEventListener("dblclick", valider); // Ajout d'un évènement double clique.
  }
}

function recup(x, y) {
  /*
  Fonction qui récupère les coordonnées du rectangle cliqué et les entres dans le formulaire dédié.
*/
  let t = document.getElementsByTagName("rect"); // Récupération des rectangles.
  for (var i = 0; i < t.length; i++) {
    t[i].setAttribute("style", ""); // Suppression du style (permet de ne pas conserver les bordures sur tout les rectangles cliqués).
  }
  document
    .getElementById(x.toString() + "-" + y.toString())
    .setAttribute("style", "stroke:black; stroke-width:0.1px"); // Ajout de la bordure.
  document.getElementById("x").value = x; // Ajout des coordonnées dans le formulaire.
  document.getElementById("y").value = y; // Ajout des coordonnées dans le formulaire.
}

function valider() {
  // Fonction qui valide le choix de l'utilisateur en soumettant le formulaire dédié.
  document.forms["formulaire"].submit();
}
