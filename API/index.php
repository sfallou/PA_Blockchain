<?php
 
use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

// Use Loader() to autoload our model
$loader = new Loader();

$loader->registerDirs(
    array(
        __DIR__ . '/models/',
        __DIR__ . '/Formulaire/'
    )
)->register();

$di = new FactoryDefault();

// Set up the database service
$di->set('db', function () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "passer",
        "dbname"   => "challenge2017",
        "options" => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )
    ));
    
});
/// je définis une fonction pour encoder et envoyer une image////
function EncoderImage($path){
$path=substr($path,1);
$path="Formulaire/$path";
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
return $base64;
}
///// je définis une fonction qui me sera utile ////////
function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 
// Create and bind the DI to the application
$app = new Micro($di);

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
//////////////////// Section Utilisateurs (Users) ///////////// 
///////////////////                               /////////////
//////////////////////////////////////////////////////////////                            


// ajouter un nouvel user
$app->post('/api/user', function () use ($app) {
    
    $user = $app->request->getJsonRawBody();
    var_dump($user);
    /*$phql = "INSERT INTO Users (id, login, mdp,mail,nom,profil,etat,credit) VALUES (:id:, :login:, :mdp:, :mail:, :nom:, :profil:, :etat:, :credit:)";

    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $user->id,
	'login' => $user->login,
        'mdp' => sha1($user->mdp),
	'mail' => $user->mail,
        'nom' => $user->nom,
        'profil' => $user->profil,
        'etat' => $user->etat,
	'credit' => $user->credit
    ));

    // Create a response
    $response = new Response();

    // Check if the insertion was successful
    if ($status->success() == true) {

        // Change the HTTP status
        $response->setStatusCode(201, "Created");

        $user->id = $status->getModel()->id;

        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $user
            )
        );

    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        // Send errors to the client
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;*/
});

// Récupere tous les utilisateurs
$app->get('/api/users', function () use ($app) {

    $phql = "SELECT * FROM Users ORDER BY id";
    $users = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($users as $user) {
        $data[] = array(
            'login'   => $user->login,
            'mdp' => $user->mdp,
            'nom' => $user->nom,
            'profil' => $user->profil,
            'etat' => $user->etat
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

$app->post('/api/users/creation/{loginmdpmail}', function ($loginmdpmail) use ($app) {
    $req = explode("-", $loginmdpmail);
    $login=$req['0'];
    $mdp=sha1($req['1']);
    $mail=$req['2'];

    $phql = "INSERT INTO Users VALUES (:id:,:login:,:mdp:,:mail:,:nom:,:profil:,:etat:,:credit:)";

    $test_mail = "SELECT count(*) AS nb_rslt FROM Users WHERE mail=:mail:";
    $test_login = "SELECT count(*) AS nb_rslt FROM Users WHERE login=:login:";

    $rslt_mail = $app->modelsManager->executeQuery($test_mail, array(
        'mail' => $mail
    ))->getFirst();
    $rslt_login = $app->modelsManager->executeQuery($test_login,array(
        'login' => $login
    ))->getFirst();

    $response = new Response();

    $val_mail = $rslt_mail->nb_rslt;
    $val_login = $rslt_login->nb_rslt;

    if ($val_mail <> 0) {
        $response->setJsonContent(
            array(
                'data' => "Ce mail est déjà utilisé."
            )
        );
    } elseif ($val_login <> 0) {
        $response->setJsonContent(
            array(
                'data' => "Ce login est déjà utilisé."
            )
        );
    } else {
        $status = $app->modelsManager->executeQuery($phql, array(
        'id' => 0,
        'login' => $login,
        'mdp' => $mdp,
        'mail' => $mail,
        'nom' => $login,
        'profil' => 'Participant',
        'etat' => 1,
        'credit' => 0
        ));

        // Check if the insertion was successful
        if ($status->success() == true) {

            // Change the HTTP status
            $response->setStatusCode(201, "Created");

            //$user->id = $status->getModel()->id;
            $var = "$login&$mdp";
            $response->setJsonContent(
                array(
                    'status' => 'OK',
                    'data'   => $var
                )
            );

        } else {

            // Change the HTTP status
            $response->setStatusCode(409, "Conflict");

            // Send errors to the client
            $errors = array();
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                array(
                    'status'   => 'ERROR',
                    'data' => $errors
                )
            );
        }
    }

    return $response;
});

///////// Récupère user à partir de son login et mdp //////////////////
$app->get('/api/users/{loginmdp}', function ($loginmdp) use ($app) {
    //on récupere les choix contenus dans la requête
    $req = explode("-", $loginmdp);
    $login=$req['0'];
    $mdp=sha1($req['1']);

    $phql = "SELECT * FROM Users WHERE login = :login: AND mdp=:mdp:";
    $user = $app->modelsManager->executeQuery($phql, array(
        'login' => $login,
        'mdp' => $mdp
    ))->getFirst();

    // Create a response
    $response = new Response();

    if ($user == false) {
        $response->setJsonContent(
            array(
                'status' => 'NOT-FOUND'
            )
        );
    } else {
        $response->setJsonContent(
            array(
                'status' => 'FOUND',
                'data'   => array(
                    'id'   => $user->id,
                    'login' => $user->login,
                    'mdp' => $user->mdp,
                    'nom' => $user->nom,
                    'profil' => $user->profil,
                    'etat' => $user->etat
                )
            )
        );
    }

    return $response;
});

/////////// Mettre à jour un user baser sur son id ///////////////
$app->put('/api/users/{id:[0-9]+}', function ($id) use ($app) {

    $user = $app->request->getJsonRawBody();

    $phql = "UPDATE Users SET login = :login:, mdp = :mdp:, nom = :nom:, profil = :profil:, etat = :etat: WHERE id = :id:";
    $status = $app->modelsManager->executeQuery($phql, array(
            'id'   => $id,
            'login' => $user->login,
            'mdp' => sha1($user->mdp),
            'nom' => $user->nom,
            'profil' => $user->profil,
            'etat' => $user->etat
    ));

    // Create a response
    $response = new Response();

    // Check if the insertion was successful
    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'=>'ok'
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;
});


///// Supprime user à partir de son id
$app->delete('/api/users/{id:[0-9]+}', function ($id) use ($app) {

    $phql = "DELETE FROM Users WHERE id = :id:";
    $status = $app->modelsManager->executeQuery($phql, array(
        'id' => $id
    ));

    // Create a response
    $response = new Response();

    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'=>'ok'
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;
});

/////////////////////// Fin de la section User /////////////////////

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
////////////////////     Section Ecoles           ///////////// 
///////////////////                               /////////////
////////////////////////////////////////////////////////////// 


// Récupere toutes les écoles
$app->get('/api/ecoles', function () use ($app) {

    $phql = "SELECT * FROM Ecoles ORDER BY id_ecole";
    $ecoles = $app->modelsManager->executeQuery($phql);
    $response=new Response();
    $response->setStatusCode(200, "OK");
    $data = array();
    foreach ($ecoles as $ecole) {
        $data[] = array(
            'id_ecole' => $ecole->id_ecole,
            'nom_ecole'   => $ecole->nom_ecole,
            'abreviation' => $ecole->abreviation,
            'points' => $ecole->points,
            'etat_ecole' => $ecole->etat_ecole,
            'logo_ecole' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($ecole->logo_ecole,1).""
            );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

///////// Récupère l'école et ses matchs à partir de son abreviation //////////////////
$app->get('/api/ecoles/{abreviation}', function ($abreviation) use ($app) {
    //on récupère les information de l'école concernée
    $phql = "SELECT * FROM Ecoles WHERE abreviation = :abreviation:";
    $ecole = $app->modelsManager->executeQuery($phql, array(
        'abreviation' => $abreviation
    ))->getFirst();

    // Create a response
    $response = new Response();

    if ($ecole == false) {
        $response->setJsonContent(
            array(
                'status' => 'NOT-FOUND'
            )
        );
    } 
    // on va récupérer l'id de l'école puis aller chercher dans la table Equipes l'ensemble des équipes de l'école
    else {
        
        $id_ecole=$ecole->id_ecole;
        $phql2 = "SELECT * FROM Equipes WHERE id_ecole=:id_ecole: ORDER BY id_equipe";
        $equipes_ecoles = $app->modelsManager->executeQuery($phql2, array(
            'id_ecole' => $id_ecole));
        $data = array();
        $listedesmatchs=array();
        //pour chaque équipe on cherche ses matchs dans la table match.
        foreach ($equipes_ecoles as $equipe) {
            $nom_equipe = $equipe->nom_equipe;
            $phql3 = "SELECT * FROM Matchs WHERE equipe1=:nom_equipe: OR equipe2=:nom_equipe: ORDER BY id_match";
            $matchs_ecole = $app->modelsManager->executeQuery($phql3, array(
            'nom_equipe' => $nom_equipe));
            foreach ($matchs_ecole as $match) {
             $listedesmatchs[]=array(
                'id_match' => $match->id_match,
                'sport'   => $match->sport,
                'equipe1' => $match->equipe1,
                'equipe2' => $match->equipe2,
                'date_match' => $match->date_match,
                'heure_match' => $match->heure_match,
                'lieu_match' => $match->lieu,
                'score1' => $match->score1,
                'score2' => $match->score2,
                'phase_match' => $match->phase,
                'etat_match' => $match->etat,
                'poule' => $match->poule
                );
                }
        }
        
       $response->setJsonContent(
            array(
                'status' => 'FOUND',
                'data'   => array(
                    'id_ecole'   => $ecole->id_ecole,
                    'nom_ecole' => $ecole->nom_ecole,
                    'abreviation' => $ecole->abreviation,
                    'points' => $ecole->points,
                    'etat_ecole' => $ecole->etat_ecole,
                    'logo_ecole' => EncoderImage($ecole->logo_ecole),
                    'matchs' =>$listedesmatchs
                )
            )
        );
        
        
    }

    return $response;
});

///// Récupere toutes les écoles par ordre de classement (1er au dernier) /////
$app->get('/api/ecoles/classement', function () use ($app) {

    $phql = "SELECT * FROM Ecoles ORDER BY points DESC";
    $ecoles = $app->modelsManager->executeQuery($phql);
    $response=new Response();
    $response->setStatusCode(200, "OK");
    $data = array();
    foreach ($ecoles as $ecole) {
        if($ecole->points > 0){
        $data[] = array(
            'id_ecole' => $ecole->id_ecole,
            'nom_ecole'   => $ecole->nom_ecole,
            'abreviation' => $ecole->abreviation,
            'points' => $ecole->points,
            'logo_ecole' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($ecole->logo_ecole,1)."",
            'etat_ecole' => $ecole->etat_ecole
            );
        }
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});
/////////////////////// Fin de la section Ecoles /////////////////////

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
////////////////////     Section Matchs           ///////////// 
///////////////////                               /////////////
////////////////////////////////////////////////////////////// 



///////// Récupère les matchs à partir des choix effectues //////////////////
$app->get('/api/matchs/{requete}', function ($requete) use ($app) {
    //on récupere les choix contenus dans la requête
    $req = explode("-", $requete);
    $sport=$req['0'];
    $sexe=$req['1'];
    //on definit le tableau contenant les matchs normaux
    $sportNormaux=array("Football","Basketball","Handball","Rugby","Volley");

    //on récupère les matchs du sport et du genre concernés dans la bdd
    $phql2 = "SELECT DISTINCT * FROM Equipes WHERE type_sport=:type_sport: AND type_equipe=:type_equipe: ORDER BY id_equipe";
    $equipes_seleted = $app->modelsManager->executeQuery($phql2, array(
         'type_sport' => $sport,
         'type_equipe' => $sexe));
    // Create a response
    $response = new Response();

    if ($equipes_seleted == false) {
        $response->setJsonContent(
            array(
                'status' => 'NOT-FOUND'
            )
        );
    } 
    else{
    $data = array();
    $listeEquipes=array();
    $matchs_trouves=array();
     //on verifie si le sport est normal
    if(in_array($sport, $sportNormaux)){
        //pour chaque équipe on cherche ses matchs dans la table match.
        foreach ($equipes_seleted as $equipe) {
            $listeEquipes[]=array(
                'equipe'=> $equipe->nom_equipe,
                'equipeTronq'=> explode(" ", $equipe->nom_equipe)[0],);
            $nom_equipe = $equipe->nom_equipe;
            $phql3 = "SELECT * FROM Matchs WHERE equipe1=:nom_equipe: OR equipe2=:nom_equipe: ORDER BY id_match";
            $matchs_selected = $app->modelsManager->executeQuery($phql3, array(
            'nom_equipe' => $nom_equipe));
        
            foreach ($matchs_selected as $match) {
             $matchs_trouves[]=array(
                'id_match' => $match->id_match,
                'sport'   => $match->sport,
                'equipe1' => $match->equipe1,
                'equipe2' => $match->equipe2,
                'equipe1Tronq'=> explode(" ", $match->equipe1)[0],
                'equipe2Tronq'=> explode(" ", $match->equipe2)[0],
                'date_match' => $match->date_match,
                'heure_match' => $match->heure_match,
                'lieu_match' => $match->lieu,
                'score1' => $match->score1,
                'score2' => $match->score2,
                'phase_match' => $match->phase,
                'etat_match' => $match->etat,
                'poule' => $match->poule
                );
        }

        }
        $matchs_trouves = array_values(unique_multidim_array($matchs_trouves,'id_match'));
        $listeEquipes = array_values(unique_multidim_array($listeEquipes,'equipeTronq'));
       $response->setJsonContent(
            array(
                'status' => 'FOUND',
                'data'   => array(
                    'sport'   => $sport,
                    'genre' => $sexe,
                    'equipes'=>$listeEquipes,
                    'matchs' =>$matchs_trouves
                )
            )
        );
    }
    else{
        //pour chaque équipe on cherche ses matchs dans la table Matchs_special.
        foreach ($equipes_seleted as $equipe) {
            $listeEquipes[]=$equipe->nom_equipe;
            $nom_equipe = $equipe->nom_equipe;
            $sql = "SELECT * FROM MatchsSpecial WHERE equipe=:nom_equipe:  ORDER BY classement_equipe";
            $matchs_special_selected = $app->modelsManager->executeQuery($sql, array(
            'nom_equipe' => $nom_equipe));
            foreach ($matchs_special_selected as $matchs_s) {
                # code...
                 $matchs_trouves[]=$matchs_s;
            }
           
        }
       $response->setJsonContent(
            array(
                'status' => 'FOUND',
                'data'   => array(
                    'sport'   => $sport,
                    'genre' => $sexe,
                    'equipes'=>$listeEquipes,
                    'matchs' =>$matchs_trouves
                )
            )
        );
    }

    }
            return $response;
});

/////////// Mettre à jour les matchs normaux baser sur les donnees reçues ///////////////
$app->post('/api/matchs/{donnees}', function ($donnees) use ($app) {
    //on récupere les choix contenus dans la requête
    $req = explode("-", $donnees);
    if(count($req)==5){
        $id_match=$req['0'];
        $equipe1=$req['1'];
        $equipe2=$req['2'];
        $score1=$req['3'];
        $score2=$req['4'];
    }
    else{
        $id_match=$req['0'];
        $score1=$req['1'];
        $score2=$req['2'];
    }

   // $resultat = $app->request->getJsonRawBody();
    $etat_match=1;
    if($equipe1 && $equipe2){
        $phql = "UPDATE Matchs SET equipe1 = :equipe1:, equipe2 = :equipe2:, score1 = :score1:, score2 = :score2:, etat = :etat_match:  WHERE id_match = :id_match:";
        $status = $app->modelsManager->executeQuery($phql, array(
            'id_match'   => $id_match,
            'equipe1' => $equipe1,
            'equipe2' => $equipe2,
            'score1' => $score1,
            'score2' => $score2,
            'etat_match' => $etat_match
    ));

    }
    else{
    $phql = "UPDATE Matchs SET score1 = :score1:, score2 = :score2:, etat = :etat_match:  WHERE id_match = :id_match:";
    $status = $app->modelsManager->executeQuery($phql, array(
            'id_match'   => $id_match,
            'score1' => $score1,
            'score2' => $score2,
            'etat_match' => $etat_match,
    ));
    }
    // Create a response
    $response = new Response();

   // si la modification a reussi, on change le statue de la réponse à retourner
    if ($status->success() == true) {
        //on retourne que la requete est ok
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'=>'ok'
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;
});

/////////// Mettre à jour le classement des matchs speciaux baser sur les donnees reçues ///////////////
$app->post('/api/matchs/special/{donnees}', function ($donnees) use ($app) {
    $req = explode("-", $donnees);
    $id_match=$req['0'];
    $classement=$req['1'];
    //$resultat = $app->request->getJsonRawBody();
    $etat_match=1;
    //if($resultat)
    $phql = "UPDATE MatchsSpecial SET classement_equipe = :classement: WHERE id_match_special = :id_match:";
    $status = $app->modelsManager->executeQuery($phql, array(
            'id_match'   => $id_match,
            'classement' => $classement
    ));

    // Create a response
    $response = new Response();

    // si la modification a reussi, on change le statue de la réponse à retourner
    if ($status->success() == true) {
    
        //on retourne que la requete est ok
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'=>'ok'
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;
});

/////////////////////// Fin de la section Match /////////////////////

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
////////////////////     Section Home             ///////////// 
///////////////////                               /////////////
////////////////////////////////////////////////////////////// 

/////////////// Récuperation des informations de la page Home //////////

$app->get('/api/home/infos', function () use ($app) {

    $phql = "SELECT * FROM Infos ORDER BY id_info DESC";
    $infos = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($infos as $info) {
        $data[] = array(
            'id_info'   => $info->id_info,
            'titre_info' => $info->titre,
            'contenu_info' => $info->contenu,
            'image_info' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($info->image_info,1)."" ,
            'date_info' => $info->date_info,
            'heure_info' => $info->heure_info
            
        );
    }
    $response->setContentType('application/json', 'UTF-8');
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

/////////////// Récuperation de photos galérie de la page galerie //////////

$app->get('/api/home/galerie', function () use ($app) {

    $phql = "SELECT * FROM Photos ORDER BY id_photo DESC";
    $photos = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($photos as $photo) {
        $data[] = array(
            'id_photo'   => $photo->id_photo,
            'photo' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($photo->chemin,1)."" ,            
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

/////////////// Récuperation des 3 derniers liens photos de la page home pour la galérie //////////

$app->get('/api/home/galerie/liens', function () use ($app) {

    $phql = "SELECT * FROM Photos ORDER BY id_photo DESC LIMIT 3";
    $last_photos = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($last_photos as $photo) {
        $data[] = array(
            'lien' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($photo->chemin,1).""            
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});
/////////////////////// Fin de la section Home /////////////////////

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
////////////////////     Section Informations     ///////////// 
///////////////////                               /////////////
////////////////////////////////////////////////////////////// 

/////////////// Récuperation le calendrier //////////

$app->get('/api/informations/calendrier', function () use ($app) {

    $phql = "SELECT * FROM Calendrier";
    $calendriers = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($calendriers as $photo) {
        $data[] = array(
            'calendrier' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($photo->chemin,1).""            
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

/////////////// Récuperation des plans  //////////

$app->get('/api/informations/plan', function () use ($app) {

    $phql = "SELECT * FROM Plans ORDER BY id_plan";
    $plans = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($plans as $photo) {
        $data[] = array(
            'plan' => "http://challenge-2016.eclair.ec-lyon.fr/Formulaire".substr($photo->chemin,1).""            
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

/////////////// Récuperation des informations de la page urgence //////////

$app->get('/api/informations/urgence', function () use ($app) {

    $phql = "SELECT * FROM Urgences ";
    $urgences = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($urgences as $urgence) {
        $data[] = array(
            'id_urgence'   => $urgence->id_urgence,
            'urgence' => $urgence->urgence,
            'numero_tel' => $urgence->numeros_tel,
            'detail_urgence' => $urgence->detail_urgence
            
        );
    }
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});

/////////////// Récuperation des informations de la page FAQ //////////

$app->get('/api/informations/faq', function () use ($app) {

    $phql = "SELECT * FROM Faq ";
    $faqs = $app->modelsManager->executeQuery($phql);
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $data = array();
    foreach ($faqs as $faq) {
        $data[] = array(
            'id_question'   => $faq->id_question,
            'titre'   => $faq->titre,
            'question' => $faq->question,
            'reponse' => $faq->reponse
            
        );
    }
    $response->setContentType('application/json', 'UTF-8');
    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $data
            )
        );
    return $response;
});


//////////// Démarrage du serveur /////////
$app->handle();
