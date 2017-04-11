var express = require('express');
var app = express() ;
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('request');
var port = process.env.PORT || 3000;

var infos="";
var id_carte = "carte9";
var historique = [];
var acteur = "" ;
var currentInterval = setInterval(requete,1000);


app.use(express.static('images')) ;

app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});


app.use('/', function(req, res){
  res.sendFile(__dirname + '/style.css');
});

/*

function maj_chemin(Infos){
	$('.modifiable').remove();
	historique = infos.historique;
	for(i=0; i < historique.length-1  ; i++){
		var elemt = historique[i];
		$('#dateE').append("<td class = 'modifiable date'>"+elemt.date_emis+"</td>");
		$('#dateR').append("<td class = 'modifiable date'>"+elemt.date_recu+"</td>");
		$('#image').append("<td class = 'modifiable'><img src = "+elemt.prop_actu+".png></img></td>");
		$('#image').append("<td class = 'modifiable'><img src = xe.png></img></td>");	
	}	
	if (infos.etat_carte == "reçue" ) {
		var elemt = historique[historique.length -1];
		$('#dateE').append("<td class = 'modifiable date'>"+elemt.date_emis+"</td>");
		$('#dateR').append("<td class = 'modifiable daye'>"+elemt.date_recu+"</td>");
		$('#image').append("<td class = 'modifiable'><img src = "+elemt.prop_actu+".png></img></td>");	
	
	}

};
*/
function requete(){
	request({
    		url: 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/historique/carte', //URL to hit
    		qs: {from: 'blog xample', time: +new Date()}, //Query string data
    		method: 'POST',
    		//Lets post the following key/values as form
    		json: {
        		id_acteur: 'CIRLY',
			id_carte: id_carte, 
    		}
	},
	function (error, response, body){
    		if(error) {
        		console.log(error);
   		 } else {
        		infos = body.data;
			console.log(body) ;
			console.log(',');
			//console.log(infos.historique);
			historique = infos.historique ;
       			console.log(historique);
			if (historique.length != 0){
				acteur = historique ;
				console.log(id_carte) ;		
				//console.log(acteur) ;
				console.log(' ');	
	        		io.emit('Maj_infos',infos) ;	
			}
		}
	}) ;
}



io.on('connection', function(socket){		
	socket.on('Maj_carte',function(n_carte){
		id_carte = n_carte ;
		console.log("Id : "+id_carte) ;
	});

}) ;

http.listen(3000, function(){
  console.log('listening on *:3000');
});

