function evenements() {
  let t = document.getElementsByTagName("rect");
  for (var i = 0; i < t.length; i++) {
    t[i].addEventListener('dblclick',valider);
  }
}

function recup(x,y) {
  let t = document.getElementsByTagName("rect");
  for (var i = 0; i < t.length; i++) {
    t[i].setAttribute("style","")
  }
  document.getElementById(x.toString()+"-"+y.toString()).setAttribute("style","stroke:black; stroke-width:0.1px");
  document.getElementById("x").value=x;
  document.getElementById("y").value=y;
}

function valider(){
  document.forms["formulaire"].submit();
}
