import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { CarteDetailsPage } from '../carte-details/carte-details';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-cartes',
  templateUrl: 'cartes.html',
  providers: [CirchainService]
})
export class CartesPage {
  selectedItem: any;
  cartes: Array<any>;
  acteur : any;
  status : String;

  constructor(public navCtrl: NavController, public navParams: NavParams, private cartesActeur: CirchainService, private loginService: LoginService)
  {
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.cartesActeur.mesCartes(this.acteur['id_acteur'],this.acteur['mdp']).subscribe(
				data => {
					this.status = data.status;
					this.cartes = data.data;
          //var donnees = JSON.parse(this.cartes);
          //console.log(this.cartes[0]);
				},
				err => {
					console.log(err);
				}
			);
  }

  itemTapped(event, item) {
    this.navCtrl.push(CarteDetailsPage, {
      item: item
    });
  }
}
