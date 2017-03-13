import { Component } from '@angular/core';
import {LoginService} from '../mesServices/loginService';
import { AccueilPage } from '../accueil/accueil';
import { CartesPage } from '../cartes/cartes';
import { ProfilPage } from '../profil/profil';
import { NotificationsPage } from '../notifications/notifications';
import {CirchainService} from '../mesServices/circhainServices';


@Component({
  templateUrl: 'tabs.html',
  providers: [CirchainService]
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
  status : any;
  result : any;
  
  constructor(private loginService: LoginService,private infosActeur: CirchainService) {
  	this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.infosActeur.mesNotifications(this.acteur['id_acteur'],this.acteur['mdp']).subscribe(
        data => {
          this.status = data.status;
          this.result = data.data;
          this.nbr_msg_unread = this.result['nombre_message_non_lus'];
        },
        err => {
          console.log(err);
        }
      );
  }
}
