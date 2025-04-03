 /* Esconder/Re-exibe os itens */
 function esconder(){
  //alert("Passei aqui");
  x=document.getElementsByClassName("esconder"); 
var i;
 for (i = 0; i < x.length; i++) {
   x[i].style.display = "none";
 }
}

function desfaz(){
  //alert("Passei aqui");
  x=document.getElementsByClassName("esconder");
  
var i;
 for (i = 0; i < x.length; i++) {
   x[i].style.display = "block";
 }  
}




function marca_para_esconder(e){
  e.className = "esconder";   
}
 
 
 /*
 Troca a cor do espiao spy.png
 */
function marcar(e) {
  // verifica se a classe azul (estilo css que conter a imagem azul) esta no elemento
  if (e.className == "azul") {
    e.className = "vermelho";
  } else {
    e.className = "azul";
  }
}

function marcarcamera(e) {
  // verifica se a classe azul (estilo css que conter a imagem azul) esta no elemento
  if (e.className == "azulcamera") {
    e.className = "vermelhocamera";
  } else {
    e.className = "azulcamera";
  }
}