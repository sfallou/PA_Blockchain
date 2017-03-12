import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-scan',
  templateUrl: 'scan.html',
  providers: [CirchainService]
})
export class ScanPage {
  selectedItem: any;
  carte: any;
  acteur : any;
  status : String;

  constructor(public navCtrl: NavController, public navParams: NavParams, private cartesActeur: CirchainService, private loginService: LoginService)
  {
    // If we navigated to this page, we will have an item available as a nav param
    this.carte = navParams.get('carte');
    console.log(this.carte);
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    /*this.cartesActeur.mesCartes(this.acteur['id_acteur'],this.acteur['mdp']).subscribe(
				data => {
					this.status = data.status;
					this.cartes = data.data;
          //var donnees = JSON.parse(this.cartes);
          //console.log(this.cartes[0]);
				},
				err => {
					console.log(err);
				}
			);*/
  }

  /*itemTapped(event, item) {
    this.navCtrl.push(CarteDetailsPage, {
      item: item
    });
  }*/
}
