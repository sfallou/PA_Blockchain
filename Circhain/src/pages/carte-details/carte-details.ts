import { Component } from '@angular/core';
import { NavController, NavParams,  ModalController } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import {InfosPage} from '../infos/infos';

@Component({
  selector: 'page-carte-details',
  templateUrl: 'carte-details.html',
  providers: [CirchainService]
})
export class CarteDetailsPage {
  selectedItem: any;
  //infosCarte: any;
  acteur : any;
  status : any;

  id_carte : any;
  date_creation : any;
  proprietaire_final: any;
  etat_carte : any;
  certification : any;
  proprietaire_actu : any;
  historique : any;

  constructor(public navCtrl: NavController, 
              public navParams: NavParams, 
              public modalCtrl: ModalController, 
              private detailsCarte: CirchainService, 
              private loginService: LoginService) {
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.detailsCarte.historiqueCarte(this.acteur['id_acteur'],this.selectedItem.id_carte).subscribe(
				data => {
					this.status = data.status;
					//this.infosCarte = data.data;
         //console.log(data.data);
         this.id_carte = data.data.id_carte;
         this.proprietaire_final = data.data.proprietaire_final;
         this.certification = data.data.certification;
         this.proprietaire_actu = data.data.proprietaire_actuel;
         this.date_creation = data.data.date_creation;
         this.etat_carte = data.data.etat_carte;
         this.historique = data.data.historique;
       

				},
				err => {
					console.log(err);
				}
			);//
  }

  

  infoCertification() {

  let obj = {A: "Certifiée A : la carte peut être intégrée dans un circuit d'avion",
             B: "Certifiée B : la carte peut être intégrée dans un circuit de train", 
             C: "Certifiée C : la carte peut être intégrée dans une carte mère d'ordinateur",
             D: "Certifiée D : la carte peut être intégrée dans n'importe quel circuit",
             E: "Certifiée E : pas encore défini",
             Vide: "S'il n'y a pas de certification, la carte n'est pas garantie par le fabricant",
           };
  let myModal = this.modalCtrl.create(InfosPage, obj);
  myModal.present();
  }
}
