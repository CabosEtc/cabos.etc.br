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