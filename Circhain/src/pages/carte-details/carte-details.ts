import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

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
  etat_carte : any;
  proprietaire_actu : any;
  historique : any;

  constructor(public navCtrl: NavController, public navParams: NavParams, private detailsCarte: CirchainService, private loginService: LoginService) {
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.detailsCarte.historiqueCarte(this.acteur['id_acteur'],this.selectedItem.id_carte).subscribe(
				data => {
					this.status = data.status;
					//this.infosCarte = data.data;
         //console.log(this.infosCarte);
         this.id_carte = data.data.id_carte;
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
}
