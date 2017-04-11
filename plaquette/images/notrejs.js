/* Variables globales*/


function mOver(i) {
	var IdE = 'dateE'+String(i);
	var IdR = 'dateR'+String(i);

	document.getElementById(IdE).innerHTML= ""; 
	document.getElementById(IdR).innerHTML= "";
} ;

function mOut(i){
	var IdE = 'dateE'+String(i);
	var IdR = 'dateR'+String(i);

	document.getElementById(IdE).innerHTML= "a"; 
	document.getElementById(IdR).innerHTML= "b";

}

function test(){ 
	document.getElementById("test").innerHTML= "b";

}

