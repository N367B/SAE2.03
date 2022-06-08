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


//Couleurs par défaut ?
//let colors = ["#FFFFFF", "#E4E4E4", "#888888", "#222222", "#FFA7D1", "#E50000", "#E59500", "#A06A42", "#E5D900", "#94E044", "#02BE01", "#00D3DD", "#0083C7", "#0000EA", "#CF6EE4", "#820080"];


function timer(timeLeft) {
  let timer = document.getElementById("timer");
  timer.innerHTML = timeLeft;
  /*if (timeLeft > 0) {
    setTimeout(function() {
      timer(timeLeft - 1);
    }, 1000);
  }*/
}
let timeLeft = 10;

while (timeLeft > 0) {
  timer(timeLeft);
  timeLeft--;
}