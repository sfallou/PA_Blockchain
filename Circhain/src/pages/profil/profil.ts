import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { CarteDetailsPage } from '../carte-details/carte-details';
//import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-profil',
  templateUrl: 'profil.html',
 // providers: [CirchainService]
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


   constructor(public navCtrl: NavController,private loginService: LoginService)
  {

    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.id = this.acteur['id_acteur'];
    this.nom = this.acteur['nom_acteur'];
    this.prenom = this.acteur['prenom_acteur'];
    this.email = this.acteur['email'];
    this.profil = this.acteur['profil'];
    this.adresse = this.acteur['adresse'];
    this.tel = this.acteur['tel'];
  }Ò
}

