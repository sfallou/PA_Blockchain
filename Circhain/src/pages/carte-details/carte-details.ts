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
  infosCarte: Array<any>;
  acteur : any;
  status : String;

  constructor(public navCtrl: NavController, public navParams: NavParams, private detailsCarte: CirchainService, private loginService: LoginService) {
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.detailsCarte.historiqueCarte(this.acteur['id_acteur'],this.selectedItem).subscribe(
				data => {
					this.status = data.status;
					this.infosCarte = data.data;

          console.log(this.infosCarte);
				},
				err => {
					console.log(err);
				}
			);
  }
}
