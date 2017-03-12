import { Component } from '@angular/core';
import {LoginService} from '../mesServices/loginService';
import { AccueilPage } from '../accueil/accueil';
import { CartesPage } from '../cartes/cartes';
import { ProfilPage } from '../profil/profil';
import { NotificationsPage } from '../notifications/notifications';


@Component({
  templateUrl: 'tabs.html'
})
export class TabsPage {
  // this tells the tabs component which Pages
  // should be each tab's root Page
  tab1Root: any = AccueilPage;
  tab2Root: any = NotificationsPage;
  tab3Root: any = CartesPage;
  tab4Root: any = ProfilPage;
  acteur: any;
  nbr_msg_unread : any;

  constructor(private loginService: LoginService) {
  	this.acteur = JSON.parse(this.loginService.getInfosActeur());
  	this.nbr_msg_unread = this.acteur['nombre_message_non_lus'];
  }
}
