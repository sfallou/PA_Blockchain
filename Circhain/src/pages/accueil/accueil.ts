import {Component} from '@angular/core';
import {NavController} from 'ionic-angular';
import {LoginService} from '../mesServices/loginService';

@Component({
    templateUrl: 'accueil.html',
    //providers: [CirchainService]
})

export class AccueilPage {

	acteur: any;

    constructor(private navController: NavController, private loginService: LoginService) {
      this.acteur = JSON.parse(this.loginService.getInfosActeur());
    }
}
