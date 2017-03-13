<?php
 
    /*
    * Classe Acteur
    **/
class Acteur{
    private $id_acteur;
    private $nom; 
    private $prenom; 
    private $email; 
    private $mdp;
    private $adresse;
    private $profil;
    private $tel;  
    private $mes_cartes; 
    private $mes_notifications;
    private $bdd; 


    function __construct($id_acteur, $nom, $prenom, $email, $mdp, $profil, $adresse, $tel){
        $this->id_acteur=$id_acteur;
        $this->mdp=$mdp;
        $this->profil=$profil;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->email=$email;
        $this->adresse=$adresse;
        $this->tel=$tel;
        // On deinit l'objet $bdd qui represente la base de donnée
        try {
            $this->bdd=new PDO('mysql:host=localhost;dbname=circhain;charset=utf8','root','passer');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e){
            $this->bdd = Null;
            die ("erreur connexion:".$e->getMessage() );
        }
    }

    function existe_acteur(){
        $req=$this->bdd->prepare('select * from Acteurs where id_acteur=:n1');
        $req->execute(array(
            ':n1'=>$this->id_acteur
        ));
        if($req->fetch()['nom_acteur']!=NULL)
            return 1;
        else
            return 0;
    }
    
    function creer_acteur(){
        if(!$this->existe_acteur()){
        $req=$this->bdd->prepare("INSERT INTO Acteurs(id_acteur, nom_acteur, prenom_acteur, email_acteur, adresse_acteur, tel_acteur, profil, timestamp, mdp) VALUES (:n1, :n2, :n3, :n4, :n5, :n6, :n7, :n8, :n9)");
        $res=$req->execute(array(
            ':n1'=>$this->id_acteur,
             ':n2'=>$this->nom, 
             ':n3'=>$this->prenom, 
             ':n4'=>$this->email,
             ':n5'=>$this->adresse,
             ':n6'=>$this->tel,
             ':n7'=>$this->profil,
             ':n8'=>time(),
             ':n9'=>$this->mdp
        ));
            if($res)
                return true;
            else
                return false;
        }
        else
            return false;
    }
    
    function get_id(){
        $req=$this->bdd->prepare('select * from Acteurs where nom_acteur=:n1 and prenom_acteur=:n2 and mdp=:n3');
        $req->execute(array(
            ':n1'=>$this->nom,
            ':n2'=>$this->prenom,
            ':n3'=>$this->mdp
        ));
        $donnees=$req->fetch();
        return $donnees['id_acteur'];
    }
    
    // Fonction authentification
    function authentifier_acteur(){
        if ($this->existe_acteur())
            return true;
        else
            return false;
    }
    // Fonction creer_carte ( utiliser uniquement pour cirly)
    function creer_carte($id_carte){
        if ($this->existe_acteur()){
            // On enregistre la carte dans la table Cartes
            $req=$this->bdd->prepare("INSERT INTO Cartes(id_carte, proprietaire_actu, etat_carte, date_creation,timestamp) VALUES (:n1, :n2, :n3, :n4, :n5)");
            $res=$req->execute(array(
            ':n1'=>$id_carte,
            ':n2'=>$this->id_acteur,
             ':n3'=>"reçue", 
             ':n4'=>date("Y-m-d H:i:s"), 
             ':n5'=>time()
            ));
            if ($res)
                return true;
            else
                return false;
        }
        else
            return false;
    }
    // Fonction envoyer_carte 
    function envoyer_carte($id_destinataire,$id_carte){
        if ($this->existe_acteur()){
            // on va récuperer les infos de la carte
            $req=$this->bdd->prepare('select * from Cartes where id_carte=:n1');
            $req->execute(array(
                ':n1'=>$id_carte
            ));
            $id=NULL;
            while ($donnes=$req->fetch()) {
                    $id=$donnes['id_carte'];
                    $proprietaire_actu=$donnes['proprietaire_actu'];
                    $etat_carte=$donnes['etat_carte'];
                    $date_creation=$donnes['etat_carte'];
                }
            if($id==NULL){
                return "cette carte n'existe pas";
            }
            // On modifie la table Cartes
            //return var_dump($this->id_acteur,'-',$proprietaire_actu);
            if($this->id_acteur==$proprietaire_actu and $etat_carte!="en transit"){
                $req=$this->bdd->prepare("UPDATE Cartes SET proprietaire_actu=:n1, etat_carte=:n2, timestamp=:n3 WHERE id_carte=:n4");
                $req->execute(array(
                ':n1'=>$id_destinataire,
                ':n2'=>"en transit", 
                ':n3'=>time(),
                ':n4'=>$id_carte
                ));

                // On enregistre la transaction dans la table Acteur_Carte
            $req=$this->bdd->prepare("INSERT INTO Acteurs_Cartes(id_proprietaire_actu, id_proprietaire_prec, id_carte, date_emis, date_recu, timestamp) VALUES (:n1, :n2, :n3, :n4, :n5, :n6)");
            $res2=$req->execute(array(
            ':n1'=>$id_destinataire,
            ':n2'=>$this->id_acteur,
             ':n3'=>$id_carte, 
             ':n4'=>date("Y-m-d H:i:s"), 
             ':n5'=>Null,
             ':n6'=>time()
            ));

                // On enregistre les informations de notifications dans la table Notifications
            $req=$this->bdd->prepare("INSERT INTO Notifications(id_acteur, id_destinataire, id_carte_concernee, type_notification, etat_notification,date_envoi, timestamp) VALUES (:n1, :n2, :n3, :n4, :n5, :n6, :n7)");
            $res2=$req->execute(array(
            ':n1'=>$this->id_acteur,
            ':n2'=>$id_destinataire,
             ':n3'=>$id_carte, 
             ':n4' =>"émise",
             ':n5' =>0,
             ':n6'=>date("Y-m-d H:i:s"), 
             ':n7'=>time()
            ));

            return true;

            }
            else
                return "cette carte ne vous appartient plus";

        }
        else
            return false;
    }
    // Fonction scanner_carte 
    function scanner_carte($id_carte){
        if ($this->existe_acteur()){
            // On verifie si l'acteur a le droit de recevoir la carte ou pas
            $req=$this->bdd->prepare('select * from Acteurs_Cartes where id_carte=:n1 and id_proprietaire_actu=:n2 order by id desc limit 1');
            $req->execute(array(
                ':n1'=>$id_carte,
                ':n2'=>$this->id_acteur,
            ));
            $id=NULL;
            while ($donnes=$req->fetch()) {
                    $date_recu=$donnes['date_recu'];
                    $id=$donnes['id_carte'];
                    $id_proprietaire_prec =$donnes['id_proprietaire_prec'];
                }
            // Si vrai, on modifie les tables Cartes, Acteurs_Cartes 
            // et on envoie l'historique de la carte
            if($id!=NULL){ //Il a le droit de lire la carte
                //return var_dump($date_recu);
                if($date_recu==NULL){  // on verifie si c'est le premier scan et si oui
                    // On modifie Acteurs_Cartes (date_reçue)
                    $req2=$this->bdd->prepare("UPDATE Acteurs_Cartes SET date_recu=:n1 WHERE id_carte=:n2 and id_proprietaire_actu=:n3");
                    $req2->execute(array(
                    ':n1'=>date("Y-m-d H:i:s"),
                    ':n2'=>$id_carte,
                    ':n3'=>$this->id_acteur
                    ));
                    // On modifie la table Cartes (etat_carte= en transit)
                    $req=$this->bdd->prepare("UPDATE Cartes SET etat_carte=:n1 WHERE id_carte=:n2");
                    $req->execute(array(
                    ':n1'=>"reçue",
                    ':n2'=>$id_carte
                    ));
                    
                        // On enregistre les informations de notifications dans la table Notifications
                    $req=$this->bdd->prepare("INSERT INTO Notifications(id_acteur, id_destinataire, id_carte_concernee, type_notification, etat_notification,date_envoi, timestamp) VALUES (:n1, :n2, :n3, :n4, :n5, :n6, :n7)");
                    $res2=$req->execute(array(
                    ':n1'=>$this->id_acteur,
                    ':n2'=>$id_proprietaire_prec,
                    ':n3'=>$id_carte, 
                    ':n4' =>"reçue",
                    ':n5' =>0,
                    ':n6'=>date("Y-m-d H:i:s"), 
                    ':n7'=>time()
                    ));
                }
                // Ensuite on récupère les infos dans la table Cartes
    
                $req3=$this->bdd->prepare('select * from Cartes where id_carte=:n1');
                $req3->execute(array(
                ':n1'=>$id_carte,
                ));
                while($donnees=$req3->fetch()){
                    $proprietaire_actuel=$donnees['proprietaire_actu'];
                    $date_creation=$donnees['date_creation'];
                    $etat_carte = $donnees['etat_carte'];
                }
                
                // On envoie l'historique de la carte
                $historiques=array();
                $req=$this->bdd->prepare('select * from Acteurs_Cartes where id_carte=:n1');
                $req->execute(array(
                ':n1'=>$id_carte,
                ));
                while($donnes=$req->fetch()){
                    $prop_actu=$donnes['id_proprietaire_actu'];
                    $prop_prec=$donnes['id_proprietaire_prec'];
                    $date_emis = $donnes['date_emis'];
                    $date_recu = $donnes['date_recu'];
                    $historiques[]=array('prop_actu'=>$prop_actu,'prop_prec'=>$prop_prec,'date_emis'=>$date_emis,'date_recu'=>$date_recu);
                }
                return array(
                        'id_carte'=>$id_carte,
                        'date_creation'=>$date_creation,
                        'etat_carte'=>$etat_carte,
                        'proprietaire_actuel'=>$proprietaire_actuel,
                        'historique'=>$historiques
                    );

            }
            else
                return "vous ne pouvez pas lire cette carte";
        }
        else
            return false;
    }
    // Lire Notifications
    function lire_notification($id_notification){
        if ($this->existe_acteur()){
            // On modifie etat_notification
                    $req=$this->bdd->prepare("UPDATE Notifications SET etat_notification=:n1 WHERE id=:n2");
                    $req->execute(array(
                    ':n1'=>1,
                    ':n2'=>$id_notification
                    ));
            return true;
        }
        else
            return false;
    }

    // Fonction mes_cartes 
    function mes_cartes(){
        if ($this->existe_acteur()){
            $req=$this->bdd->prepare('select * from Acteurs_Cartes where id_proprietaire_actu=:n1 or id_proprietaire_prec=:n1 ');
            $req->execute(array(
                ':n1'=>$this->id_acteur,
            ));
            $data=array();
            while ($donnes=$req->fetch()) {
                    $data[]=array('id_carte'=>$donnes['id_carte']);
            }
            return $data;
        }
        else
            return false;
    }

    // Historique carte  
    function historique_carte($id_carte){
        if ($this->existe_acteur()){
                // Ensuite on récupère les infos dans la table Cartes
                $req3=$this->bdd->prepare('select * from Cartes where id_carte=:n1');
                $req3->execute(array(
                ':n1'=>$id_carte,
                ));
                while($donnees=$req3->fetch()){
                    $proprietaire_actuel=$donnees['proprietaire_actu'];
                    $date_creation=$donnees['date_creation'];
                    $etat_carte = $donnees['etat_carte'];
                }
                
                // On envoie l'historique de la carte
                $historiques=array();
                $req=$this->bdd->prepare('select * from Acteurs_Cartes where id_carte=:n1');
                $req->execute(array(
                ':n1'=>$id_carte,
                ));
                while($donnes=$req->fetch()){
                    $prop_actu=$donnes['id_proprietaire_actu'];
                    $prop_prec=$donnes['id_proprietaire_prec'];
                    $date_emis = date_create($donnes['date_emis']);
                    $date_recu = date_create($donnes['date_emis']);
                    $date_emis = date_format($date_emis,'d/m/Y H:i:s');
                    $date_recu = date_format($date_recu,'d/m/Y H:i:s');
                    $historiques[]=array('prop_actu'=>$prop_actu,'prop_prec'=>$prop_prec,'date_emis'=>$date_emis,'date_recu'=>$date_recu);
                }
                return array(
                        'id_carte'=>$id_carte,
                        'date_creation'=>$date_creation,
                        'etat_carte'=>$etat_carte,
                        'proprietaire_actuel'=>$proprietaire_actuel,
                        'historique'=>$historiques
                    );
        }
        else
            return false;
    }
/********************************************************************************/
/* Les fonctions static 
/********************************************************************************/
    // Fonction static qui permet d'avoir les infos d'un acteur sans instancier un objet
    static function infos_acteur($id){
        // On deinit l'objet $bdd qui represente la base de donnée
        try {
            $bdd=new PDO('mysql:host=localhost;dbname=circhain;charset=utf8','root','passer');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e){
            $bdd = Null;
            die ("erreur connexion:".$e->getMessage() );
        }
        $req=$bdd->prepare('select * from Acteurs where id_acteur=:n1');
        $req->execute(array(
            ':n1'=>$id
        ));
        $data =array();
        $messages_envoyes = array();
        $messages_recus = array();
        $nbr_messages_recus_non_lu = 0;
        while($donnes=$req->fetch()){
                    $data['id_acteur']=$donnes['id_acteur'];
                    $data['nom']=$donnes['nom_acteur'];
                    $data['prenom']=$donnes['prenom_acteur'];
                    $data['email']=$donnes['email_acteur'];
                    $data['mdp']=$donnes['mdp'];
                    $data['adresse']=$donnes['adresse_acteur'];
                    $data['tel']=$donnes['tel_acteur'];
                    $data['profil']=$donnes['profil'];
            }
        $req2=$bdd->prepare('select * from Notifications where id_destinataire=:n1 or id_acteur=:n1');
        $req2->execute(array(
            ':n1'=>$id
        ));
        while($donnes2=$req2->fetch()){
                if($donnes2['id_acteur']==$id){
                    $date_envoi = date_create($donnes2['date_envoi']);
                    $date_envoi = date_format($date_envoi,'d/m/Y H:i:s');
                    $messages_envoyes[] = array(
                        'id_notification'=>$donnes2['id'],
                        'id_destinataire'=>$donnes2['id_destinataire'],
                        'id_carte_concernee'=>$donnes2['id_carte_concernee'],
                        'type_notification'=>$donnes2['type_notification'],
                        'date_envoi'=>$date_envoi);
                }
                else{
                    $date_envoi = date_create($donnes2['date_envoi']);
                    $date_envoi = date_format($date_envoi,'d/m/Y H:i:s');
                    $messages_recus[] = array(
                        'id_notification'=>$donnes2['id'],
                        'id_emetteur'=>$donnes2['id_acteur'],
                        'id_carte_concernee'=>$donnes2['id_carte_concernee'],
                        'type_notification'=>$donnes2['type_notification'],
                        'etat_notification'=>$donnes2['etat_notification'],
                        'date_envoi'=>$date_envoi);
                    if($donnes2['etat_notification']==0)
                        $nbr_messages_recus_non_lu = $nbr_messages_recus_non_lu +1;
                }

            }
            $data['nombre_message_non_lus'] = $nbr_messages_recus_non_lu;
            $data['messages_envoyes'] = $messages_envoyes;
            $data['messages_recus'] = $messages_recus;

            return $data;
    }

    // Fonction static qui permet d'avoir la listes des acteurs
    static function les_acteurs(){
        // On deinit l'objet $bdd qui represente la base de donnée
        try {
            $bdd=new PDO('mysql:host=localhost;dbname=circhain;charset=utf8','root','passer');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e){
            $bdd = Null;
            die ("erreur connexion:".$e->getMessage() );
        }
        $req=$bdd->query('select * from Acteurs');
        $data =array();

        while($donnes=$req->fetch()){
                    $id_acteur=$donnes['id_acteur'];
                    $nom=$donnes['nom_acteur'];
                    $prenom=$donnes['prenom_acteur'];
                    $email=$donnes['email_acteur'];
                    $mdp=$donnes['mdp'];
                    $adresse=$donnes['adresse_acteur'];
                    $tel=$donnes['tel_acteur'];
                    $profil=$donnes['profil'];
                    $data[]=array(
                        'id_acteur'=>$id_acteur,
                        'nom_acteur'=>$nom,
                        'prenom_acteur'=>$prenom,
                        'email_acteur'=>$email,
                        'mdp'=>$mdp,
                        'adresse_acteur'=>$adresse,
                        '$tel'=>$tel,
                        'profil'=>$profil
                        );
        }
        return $data;
    }

}

/************************************************/
/* Début phalcon
/************************************************/

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
        __DIR__ . '/Demo/'
    )
)->register();

$di = new FactoryDefault();

// Set up the database service
$di->set('db', function () {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "passer",
        "dbname"   => "circhain",
        "options" => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        )
    ));
    
});

// Create and bind the DI to the application
$app = new Micro($di);

////////////////////////////////////////////////////////////////
/////////////////////                             //////////////
//////////////////// Section Utilisateurs (Acteurs) /////////// 
///////////////////                               /////////////
//////////////////////////////////////////////////////////////                            


// ajouter un nouvel acteur
$app->post('/api/creer/acteur', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $acteur = $app->request->getJsonRawBody();

    $id_acteur =$acteur->id_acteur;
    $nom =$acteur->nom_acteur;
    $prenom=$acteur->prenom_acteur;
    $email=$acteur->email_acteur;
    $mdp =sha1($acteur->mdp);
    $profil=$acteur->profil;
    $adresse =$acteur->adresse;
    $tel=$acteur->tel;
    // On va instancier un objet de la classe Acteur
    $new_acteur = new Acteur($id_acteur, $nom, $prenom, $email, $mdp, $profil, $adresse, $tel);
    $bool = $new_acteur->creer_acteur();
    // On crée la  response à renvoyer  
    $response = new Response();

    // On verifie si la creation s'est bien passé ou pas
    if ($bool) {

        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $acteur
            )
        );

    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        // Send errors to the client
        $errors = " Impossible de créer l'acteur, veuillez contacter l'administrateur ";

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );
    }

    return $response;
});

// Récupere tous les  acteurs
$app->get('/api/acteurs', function () use ($app) {

    $acteurs = Acteur::les_acteurs();
    // Create a response
    $response = new Response();
    // Change the HTTP status
    $response->setStatusCode(200, "OK");

    $response->setJsonContent(
            array(
                'status'   => 'OK',
                'data' => $acteurs
            )
        );
    return $response;
});

///////// Récupère user à partir de son id //////////////////
$app->post('/api/acteur', function () use ($app) { 
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0){
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $acteur
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});

// Authentifier acteur avec son id et son mdp et renvoyer ses données
$app->post('/api/acteur/auth', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    $mdp =sha1($infos_envoi->mdp);
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0 and $mdp==$acteur['mdp']){
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $acteur
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain ";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});


// ajouter une nouvelle carte
$app->post('/api/cirly/creer/carte', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos = $app->request->getJsonRawBody();

    $id_acteur =$infos->id_acteur;
    $id_carte =$infos->id_carte;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    // on verifie si c'est cirly ou pas
    if(count($acteur) and $acteur['profil']=="administrateur"){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool=$new_acteur->creer_carte($id_carte);
        if($bool){
            // Change the HTTP status
            $response->setStatusCode(201, "Created");
            $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $id_carte
                )
            );
        }
        else{
            // Change the HTTP status
            $response->setStatusCode(409, "Conflict");
            // Send errors to the client
            $errors = " Impossible de créer la carte";
            $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
                )
            );

        }
    }
    else{
        // Change the HTTP status
            $response->setStatusCode(409, "Conflict");
            // Send errors to the client
            $errors = " Erreur, cette identifiant n'existe pas dans la blockchain";
            $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
                )
            );
    }
    return $response;
});
// envoyer une carte
$app->post('/api/acteur/envoyer/carte', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    $id_destinataire =$infos_envoi->id_destinataire;
    $id_carte =$infos_envoi->id_carte;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool=$new_acteur->envoyer_carte($id_destinataire,$id_carte);
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $bool
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain ";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});

// scanner une carte
$app->post('/api/acteur/scanner/carte', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    $id_carte =$infos_envoi->id_carte;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool=$new_acteur->scanner_carte($id_carte);
        if(is_array($bool))
            $val_staut = 'OK';
        else
            $val_staut = 'NOT';
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => $val_staut,
                'data'   => $bool
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});

// Récuperer mes cartes
$app->post('/api/acteur/mes/cartes', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    $mdp =$infos_envoi->mdp;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0 and $acteur['mdp']==$mdp){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool=$new_acteur->mes_cartes();
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $bool
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, les infos fournis ne sont pas conformes";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});

// historique d'une carte
$app->post('/api/acteur/historique/carte', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_acteur =$infos_envoi->id_acteur;
    $id_carte =$infos_envoi->id_carte;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool=$new_acteur->historique_carte($id_carte);
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $bool
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});

// Lire notification
$app->post('/api/acteur/lire/notification', function () use ($app) {
    
    // On récupère les infos en json qu'on traduit en objet php
    $infos_envoi = $app->request->getJsonRawBody();
    $id_notification =$infos_envoi->id_notification;
    $etat_notification =$infos_envoi->etat_notification;
    $id_acteur =$infos_envoi->id_acteur;
    // On crée la  response à renvoyer  
    $response = new Response();
    //On récupères les données de l'acteur
    $acteur = Acteur::infos_acteur($id_acteur);
    if(count($acteur)>0){
        // On va instancier un objet de la classe Acteur
        $new_acteur = new Acteur($id_acteur,$acteur['nom'],$acteur['prenom'],$acteur['email'],$acteur['mdp'],$acteur['profil'],$acteur['adresse'],$acteur['tel']);
        $bool = true;
        if($etat_notification == 0) // si le message n'est pas encore lu
            $bool=$new_acteur->lire_notification($id_notification);
        // Change the HTTP status
        $response->setStatusCode(201, "Created");
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $bool
            )
        );
    }
    else{
        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");
        // Send errors to the client
        $errors = " Erreur, cette identifiant n'existe pas dans la blockchain ";
        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'data' => $errors
            )
        );

    }
    return $response;
});



//////////// Démarrage du serveur /////////
$app->handle();
