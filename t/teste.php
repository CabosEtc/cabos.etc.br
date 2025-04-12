<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<title>Teste</title>
</head>
<body>
 
 <style>
 /*
 Style referente a marcacao para esconder/mostrar
 */
 
 .mostrar {
  float: none;
  display: block;
}
.esconder {
 float: none;
  display: block;
}
 </style>
    
<script>
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
</script>   
    
 <div id="div1" style='float: none; width: 700px; margin: 0' name="nome" class="mostrar" onclick="marca_para_esconder(this)"><div style='float:left; width:20px; margin: 10px 10px 10px 10px'> 1</div><div style='float:left; width:50px'>coluna 2</div><div style='float:none'>coluna 3</div></div>
 <div id="div2" style='clear: both; float: none; width: 700px; margin: 0' name="nome" class="mostrar" onclick="marca_para_esconder(this)"><div style='float:left; width:20px; margin:  10px 10px 10px 10px'>2</div><div style='float:left; width:50px'>coluna 2 este texto eh maior</div><div style='float:none'>coluna 3</div></div>
<div id="div3" style='clear: both; float: none; width: 700px; margin: 0' name="nome" class="mostrar" onclick="marca_para_esconder(this)"><div style='float:left; width:20px; margin:  10px 10px 10px 10px'>2</div><div style='float:left; width:50px'>coluna 2 este texto eh maior</div><div style='float:none'>coluna 3</div></div>

<!--
 <div id="div3" name="nome" class="mostrar" onclick="marca_para_esconder(this)"><div style='float:left; width:200px; margin:  10px 10px 10px 10px'>3</div><div style='float:left; width:300px'>coluna 2</div><div style='float:right'>coluna 3</div></div>
 <div id="div4" name="nome" class="mostrar" onclick="marca_para_esconder(this)"><div style='float:left; width:200px; margin:  10px 10px 10px 10px'>4</div><div style='float:left; width:300px'>coluna 2</div><div style='float:right'>coluna 3</div></div>
 !-->
   
 
 
<div style='clear: both; float: none'><button type="button" onclick="esconder()">Esconder</button>
<button type="button" onclick="desfaz()">Exibe novamente</button>   </div>
    
    
    
</body>
</html>
