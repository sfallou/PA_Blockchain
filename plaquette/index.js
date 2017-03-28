var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var request = require('request');

var infos="";
var Id_carte = "carte3";
var historique = [];
/*
request({
        url: 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/historique/carte', //URL to hit
        qs: {from: 'blog xample', time: +new Date()},
        method: 'POST',
        json: {
                id_acteur: 'CIRLY',
                id_carte: Id_carte,
        }
        },
        function (error, response, body){
                if(error) {
                        console.log(error);
                 } else {
                        infos = body.data;
		}
});
*/

app.get('/', function(req, res){
  res.render('table', {
  items: infos
});
});



//Lets configure and request
function requete_et_impression(){
	request({
    	url: 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/historique/carte', //URL to hit
    	qs: {from: 'blog xample', time: +new Date()}, //Query string data
    	method: 'POST',
    	//Lets post the following key/values as form
    	json: {
        	id_acteur: 'CIRLY',
		id_carte: Id_carte, 
    	}
	},
	function (error, response, body){
    		if(error) {
        		console.log(error);
   		 } else {
        		infos = body.data;
			historique = infos.historique ;
       			// console.log(response.statusCode, infos);
	       		for(var i=0; i < historique.length; i++) {
	       	 		console.log(historique[i].prop_actu);
        		}
		}
}) ;
} 

setInterval(requete_et_impression,3000) ;


http.listen(3000, function(){
  console.log('listening on *:3000');
});

