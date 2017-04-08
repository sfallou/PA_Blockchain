var express = require('express');
var app = express() ;
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

app.use(express.static('images')) ;

app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});


app.use('/', function(req, res){
  res.sendFile(__dirname + '/style.css');
});
/*
app.use('/', function(req, res){
  //res.sendFile(__dirname + '/notrejs.js');
  res.sendFile('/Center_Picture.png');
});
*/
/*
app.use('/', function(req, res){
  res.sendFile(__dirname + '/AsteelFlash.png');
});

app.use('/', function(req, res){
  res.sendFile(__dirname + '/Areva.png');
});

app.use('/', function(req, res){
  res.sendFile(__dirname + '/axe.png');
});

app.use('/', function(req, res){
  res.sendFile(__dirname + '/BSE.png');
});

app.use('/', function(req, res){
  res.sendFile(__dirname + '/CTS.png');
});

app.use('/', function(req, res){
  res.sendFile(__dirname + '/Bird_Picture.png'); 
});

app.use('/', function(req, res){
  //app.use(express.static('images')) ;
  //app.use('/static', express.static(path.join(__dirname, 'public'))) ;


});

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
			console.log(infos.historique);
			historique = infos.historique ;
       			// console.log(response.statusCode, infos);
			if (historique.length != 0){
	       			/*for(var i=0; i < historique.length; i++) {
	       	 			console.log(historique[i].prop_actu);
        			} ; */
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

