import {Component} from '@angular/core';
import {NavController} from 'ionic-angular';
//import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
    templateUrl: 'accueil.html',
    //providers: [CirchainService]
})

export class AccueilPage {

	acteur: any;

    constructor(private navController: NavController, private loginService: LoginService) {
      this.acteur = JSON.parse(this.loginService.getInfosActeur());
     //this.nom = this.acteur['id_acteur'];
      //console.log(this.acteur);
    }


	/*itemTapped(event, movie) {
		console.log(movie);
		this.navController.push(MovieInfo, {
			movie: movie
		});
	}*/
}
