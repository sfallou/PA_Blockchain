var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('request');
var port = process.env.PORT || 3000;

var infos="";
var id_carte = "carte2";
var historique = [];
var acteur = "" ;
var currentInterval = setInterval(requete,1000);


// cours ; cd ../PA/PA_Blockchain/plaquette/


app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});




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
			historique = infos.historique ;
       			// console.log(response.statusCode, infos);
			if (historique.length != 0){
	       			/*for(var i=0; i < historique.length; i++) {
	       	 			console.log(historique[i].prop_actu);
        			} ; */
				acteur = historique[historique.length - 1].prop_actu ;
				console.log(id_carte) ;		
				console.log(acteur) ;
				console.log(' ');	
	        		io.emit('Maj',acteur) ;	
			}
		}
	}) ;
}



io.on('connection', function(socket){		
	socket.on('Maj',function(n_carte){
		id_carte = n_carte ;
		console.log("Id : "+id_carte) ;
	});

}) ;

http.listen(3000, function(){
  console.log('listening on *:3000');
});

