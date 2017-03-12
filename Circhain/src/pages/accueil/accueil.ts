import {Component} from '@angular/core';
import {Validators, FormBuilder, FormGroup } from '@angular/forms';
import {NavController, NavParams} from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import { TabsPage } from '../tabs/tabs';

@Component({
    templateUrl: 'accueil.html',
    providers: [CirchainService]
})

export class AccueilPage {
	private carte : FormGroup;
 	private result : any;
 	private status : String;
	acteur: any;

    constructor(private navController: NavController,
    		 	private loginService: LoginService,
    		 	private formBuilder: FormBuilder,
    		 	private infosActeur: CirchainService
    		 	) {
      this.acteur = JSON.parse(this.loginService.getInfosActeur());
      this.carte = this.formBuilder.group({
      id: ['', Validators.required]
    });
    }

    scanCarte(){
    //console.log(this.acteur.value.mdp);
    this.infosActeur.scannerCarte(this.acteur['id_acteur'],this.carte.value.id).subscribe(
				data => {
					this.status = data.status;
					this.result = data.data;
					if(this.status === "OK")
						console.log(this.result);
					else
						console.log("Not good");
				},
				err => {
					console.log(err);
				}
			);

  }

}



