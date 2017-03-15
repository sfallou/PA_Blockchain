import {Component} from '@angular/core';
import { BarcodeScanner } from 'ionic-native';

import {NavController, NavParams, AlertController} from 'ionic-angular';
// ne pas oublier de faire  : ionic plugin add phonegap-plugin-barcodescanner


import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import {ScanPage} from '../scan/scan';
//import { TabsPage } from '../tabs/tabs';

@Component({
	selector: 'page-accueil',
    templateUrl: 'accueil.html',
    providers: [CirchainService],
  //directives: [QRCodeComponent],
})









export class AccueilPage {
 	private result : any;
 	private status : String;
	acteur: any;

    constructor(private navController: NavController,
    			private navParams: NavParams,
    		 	private loginService: LoginService,
    		 	public alertCtrl: AlertController,
    		 	private infosActeur: CirchainService
    		 	) {
      this.acteur = JSON.parse(this.loginService.getInfosActeur());
    }


 
    click() {
            BarcodeScanner.scan().then((result) => {
		this.infosActeur.scannerCarte(this.acteur['id_acteur'],result.text).subscribe(
				data => {
					this.status = data.status;
					this.result = data.data;
					if(this.status === "OK" && this.result['proprietaire_actuel']===this.acteur['id_acteur']){
						console.log(this.result);
						this.navController.push(ScanPage, {carte: this.result});
						}
					else{
						//console.log("Not good");
						let alert = this.alertCtrl.create({
      					title: "Attention!",
      					subTitle: "Vous n'avez pas le droit de scanner cette carte",
      					buttons: ['OK']
    					});
    					alert.present();
  						}
				},
				err => {
					console.log(err);
				}
			);
            }, (error) => {
                let alert = this.alertCtrl.create({
                    title: "Attention!",
                    subTitle: error,
                    buttons: ["Close"]
                }); 
		alert.present() ;
            });
        
    }


}



