import { Component } from '@angular/core';

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

  constructor() {

  }
}
