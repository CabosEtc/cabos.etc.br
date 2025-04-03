<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Javascript</title>
</head>
<body>
<style type="text/css">
a { 
border: none;
text-decoration: none;
COLOR:#0000FF; 
FONT-FAMILY: verdana; 
}
</style>
<div id="menu">
| <a href="index.php" >Dicas</a> 
| <a href="https://www.w3schools.com/Js/default.asp" >Fonte</a> 
| <a href="#condicoes">Condições</a> 
| <a href="#loops">Loops</a> 
| <a href="#json">Json</a> 
| <a href="#ajax">Ajax</a> 
| <a href="#array">Array</a> 
| <a href="#DOM">DOM Document Object Model</a>  
| <a href="#trocaimagem">Trocar imagem</a>  
| <a href="https://www.w3schools.com/jsref/met_win_open.asp">Window.open</a> 

</div>


<div>JS Forms / JS Objects /  JS Functions/ JS HTML DOM / JS Browser BOM / JS AJAX / JS JSON / JS vs jQuery / JS Examples / JS References</div>

<h2><font color="#0000FF">Estrutura</font></h2>
<pre>
>script type="text/javascript">
var n=0; // declarar variaveis

function contador(param1, param2){ // declara a funcao e recebe parametros em param1 e param2
 document.getElementById("relogio").innerHTML=n;
 n++; // incrementa +1
 if (n==60){
	 makerequest("teste_ajax2.php","hw");
	 n=0;
 }
}

setInterval(contador(), 1000); // chama funcao contador() a cada segundo

>script>
</pre>


<h2><font color="#0000FF">Operadores</font></h2>

<pre>
+	Addition
-	Subtraction
*	Multiplication
**	Exponentiation (ES2016)
/	Division
%	Modulus (Division Remainder)
++	Increment
--	Decrement
</pre>

<pre>
=	x = y	x = y
+=	x += y	x = x + y
-=	x -= y	x = x - y
*=	x *= y	x = x * y
/=	x /= y	x = x / y
%=	x %= y	x = x % y
**=	x **= y	x = x ** y
</pre>

<pre>
==	equal to
===	equal value and equal type
!=	not equal
!==	not equal value or not equal type
>	greater than
<	less than
>=	greater than or equal to
<=	less than or equal to
?	ternary operator
</pre>
<h2><font color="#0000FF">Operadores Lógicos</font></h2>
<pre>
&&	logical and
||	logical or
!	logical not
</pre>

<h2><font color="#0000FF">Type Operators</font></h2>
<pre>
ypeof	Returns the type of a variable
instanceof	Returns true if an object is an instance of an object type

</pre>

<h2 id="condicoes" title="Voltar ao topo"><a href="#menu" >Conditions</a></h2>
<pre>
if (time < 10) {
  greeting = "Good morning";
} else if (time < 20) {
  greeting = "Good day";
} else {
  greeting = "Good evening";
}
</pre>
<h3>Switch</h3>
<pre>
switch (new Date().getDay()) {
  case 0:
    day = "Sunday";
    break;
  case 1:
    day = "Monday";
    break;
  case 2:
     day = "Tuesday";
    break;
  case 3:
    day = "Wednesday";
    break;
  case 4:
    day = "Thursday";
    break;
  case 5:
    day = "Friday";
    break;
  case 6:
    day = "Saturday";
}
</pre>

<h2 id="loops" title="Voltar ao topo"><a href="#menu" >Loops</a></h2>
<h3>For</h3>
<pre>
for (i = 0, len = cars.length, text = ""; i < len; i++) {
  text += cars[i] + "<br>";
}

e tambem...

var cars = ['BMW', 'Volvo', 'Mini'];
var x;

for (x of cars) {
  document.write(x + "<br >");
}

</pre>
<h3>do/While</h3>
<pre>
do/while executa pelo menos uma vez, já que avalia no final

do {
  text += "The number is " + i;
  i++;
}
while (i < 10);

O while avalia no inicio

while (i < 10) {
  text += "The number is " + i;
  i++;
}

</pre>

<h3>Break/Continue</h3>
<pre>
* The break statement can also be used to jump out of a loop.  

for (i = 0; i < 10; i++) {
  if (i === 3) { break; }
  text += "The number is " + i + "<br>";
}

* The continue statement breaks one iteration (in the loop), if a specified condition occurs, and continues with the next iteration in the loop.


for (i = 0; i < 10; i++) {
  if (i === 3) { continue; }
  text += "The number is " + i + "<br>";
}

* Estudar mais sobre Label:

break labelname;

continue labelname;
</pre>

<h2><font color="#0000FF">Arrow function</font></h2>
<pre>
Before:
hello = function() {
  return "Hello World!";
}

With Arrow Function:
hello = () => {
  return "Hello World!";
}

Arrow Function With Parameters:
hello = (val) => "Hello " + val;

</pre>

<h2 id="json" title="Voltar ao topo"><font color="#0000FF"><a href="#menu">JSON</a></font></h2>
<div title="Clique para experimentar"><a href="../../t/tPergunta.php" >Exemplo: tPergunta.php</a> - Este arquivo abre outra pagina, tExtract.php, que fornece os dados 
em formato JSON, transformado em objeto por json.parse e um laço for exibe os itens retornados atraves de um alert() </div>
<div title="Clique para experimentar"><a href="../../t/jsonparse.php" >Exemplo: jsonparse.php</a> - Este arquivo faz praticamente o mesmo
que o exemplo acima, mas tem um nivel a menos no objeto, interessante ver a diferença.</div>
<pre>
JSON is a format for storing and transporting data.

JSON is often used when data is sent from a server to a web page.

JSON Example
{
"employees":[
  {"firstName":"John", "lastName":"Doe"},
  {"firstName":"Anna", "lastName":"Smith"},
  {"firstName":"Peter", "lastName":"Jones"}
]
}

* Converting a JSON Text to a JavaScript Object

var text = '{ "employees" : [' +
'{ "firstName":"John" , "lastName":"Doe" },' +
'{ "firstName":"Anna" , "lastName":"Smith" },' +
'{ "firstName":"Peter" , "lastName":"Jones" } ]}';

var obj = JSON.parse(text);

Example
>p< id="demo">/p<

>script<
document.getElementById("demo").innerHTML =
obj.employees[1].firstName + " " + obj.employees[1].lastName;
>/script<

</pre>

<h2 id="ajax" title="Voltar ao topo"><font color="#0000FF"><a href="#menu" >Ajax</a></font></h2>
<PRE>

* Conceito:
1- Um aquivo inicializa o objeto xmlhttp (feito pelo arquivo ajax2020.js, anexado a pagina por >script src="ajax2020.js">
2- Um campo deve ser definido dentro de uma div, no exemplo o id="hw"
3- Fazer a chamada cfe a funcao makerequest abaixo.
4- Note que ha um exemplo de automacao utilizando um contador feito a partir da funcao setInterval.

// ------------------ declaracao no arquivo ajax2020.js -----------
var xmlhttp = false;
 
 try{ 
	xmlhttp = new ActiveXObject("Msxm12.XMLHTTP");
      //alert("Voce esta usando Internet Explorer");
 } catch (e){
	 try{
		 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		 //alert("Voce esta usando Internet Explorer");
	 } catch (E){
		 xmlhttp = false;
	 }
 }
 
 if(!xmlhttp && typeof XMLHttpRequest != 'undefined'){
	 xmlhttp = new XMLHttpRequest();
	 //alert ("Voce esta usando outro navegador");
 }

// ------------------ fim do arquivo aja2020.js ---------------------

// Funcao para buscar o conteudo da pagina via ajax 
 function makerequest(serverPage, objID){
	 
	 var obj=document.getElementById(objID);
	 xmlhttp.open("GET", serverPage);
	 xmlhttp.onreadystatechange=function(){
		 if(xmlhttp.readyState==4 && xmlhttp.status==200){
			 obj.innerHTML=xmlhttp.responseText+">BR>"+obj.innerHTML;
		 }
		 
	 }
	 xmlhttp.send(null);
	 //alert(xmlhttp.status);
 }
>div id="hw">Aqui o texto trazido pelo ajax vai aparecer>/div>

</PRE>

<h2 id="array" title="Voltar ao topo"><a href="#menu" ><img src='../../imagens/home.png' />Array</a></h2>
<PRE>


<B>Criar:</B>

Let numeros=[0,1,2,3,4,5,6,1];

<B>Incluir elemento:</B>

* No fim do array

numeros.push(7); // insere um numero 7 no final do array

* No inicio

numeros.unshift(-1); // insere um numero -1 antes do 0

<B>Excluir elemento:</B>

* No fim do array

Let numeroRemovido = numeros.pop(); // 1

* No inicio

Let numeroRemovido=numeros.shift(); // 0

<B>Procurar/obter a chave de um elemento pesquisado:</B>

console.log(numeros.indexOf(1));  // 1
console.log(numeros.lastIndexOf(1)); // 7

<B>Varrer elementos da array:</B>

numeros.forEach (num => { // na estrutura arrow function
  console.log(num);
});


<B>Retornar um array a partir de outro:</B>

console.log(numeros.slice(2,3)); // 
console.log(numeros.slice(3)); // 

<B>Contar elementos da array:</B>

console.log(numeros.length);

<B>Verificar se existe o elemento na array</B>

console.log(numeros.includes(5)); // true pois o array tem um elemento 5


</PRE>

<h2 id="DOM" title="Voltar ao topo"><a href="#menu" >DOM - Manipulação de elementos da página através do javascript</a></h2>
<div><img src="../../imagens/dom.png" /></div>
<PRE>
document.getElementById('modo_carrinho').value='calcular_frete';
document.getElementById('form_carrinho').action='carrinho.php';
document.getElementById('form_carrinho').submit();
document.getElementById('camera').src='../imagens/camera.png';
document.getElementById('frete').innerHTML='22.90';
document.getElementById('relatorio_acumulado').style.display = 'block';
</PRE>


<h2 id="trocaimagem" title="Voltar ao topo"><a href="#menu" >Como trocar a origem de uma imagem por codigo</a></h2>
<pre>
function trocacamera(identificador){
	var objeto=document.getElementById(identificador);
	//alert(identificador);
	objeto.src='../imagens/camera2.png';
}
	
No código:
>img id='$idcamera' src='../imagens/camera.png'  onclick='trocacamera(\"$idcamera\");'<
</pre>

</body>
</html>