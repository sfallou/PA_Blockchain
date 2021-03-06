import { Component } from '@angular/core';
import { NavController, App} from 'ionic-angular';
import {LoginService} from '../mesServices/loginService';
import {LoginPage} from '../login/login';

@Component({
  selector: 'page-profil',
  templateUrl: 'profil.html',
  //providers: [AccueilPage]
})
export class ProfilPage {
  acteur : any;

  id : String;
  nom : String;
  prenom : String;
  email : String;
  profil : String;
  adresse : String;
  tel : String;


   constructor(public navCtrl: NavController,public app: App,private loginService: LoginService)
  {

    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.id = this.acteur['id_acteur'];
    this.nom = this.acteur['nom_acteur'];
    this.prenom = this.acteur['prenom_acteur'];
    this.email = this.acteur['email'];
    this.profil = this.acteur['profil'];
    this.adresse = this.acteur['adresse'];
    this.tel = this.acteur['tel'];
  }

  deconnexion(){
    this.app.getRootNav().setRoot( LoginPage );
  }
}

