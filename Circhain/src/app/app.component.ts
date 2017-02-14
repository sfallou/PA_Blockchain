import { Component, ViewChild } from '@angular/core';

import { Platform, MenuController, Nav } from 'ionic-angular';

import { StatusBar, Splashscreen } from 'ionic-native';

//import { MesServices } from '../pages/mesServices/mesServices';
//import { EcoleService } from '../pages/mesServices/test';
import { AccueilPage } from '../pages/accueil/accueil';
import { CartesPage } from '../pages/cartes/cartes';
//import { CarteDetailsPage } from '../pages/carte-details/carte-details';
import { ProfilPage } from '../pages/profil/profil';
import { NotificationsPage } from '../pages/notifications/notifications';


@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;

  // make Accueil the root (or first) page
  rootPage: any = AccueilPage;
  pages: Array<{title: string, component: any}>;

  constructor(
    public platform: Platform,
    public menu: MenuController
  ) {
    this.initializeApp();

    // set our app's pages
    this.pages = [
      { title: 'Accueil', component: AccueilPage },
      { title: 'Mes cartes', component: CartesPage },
      { title: 'Mes notifications', component: NotificationsPage },
      { title: 'Mon profil', component: ProfilPage },
    ];
  }

  initializeApp() {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();
    });
  }

  openPage(page) {
    // close the menu when clicking a link from the menu
    this.menu.close();
    // navigate to the new page if it is not the current page
    this.nav.setRoot(page.component);
  }
}
