import { Component } from '@angular/core';
import { Platform } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';

import { LoginService } from '../pages/mesServices/loginService';
import { LoginPage } from '../pages/login/login';
/*
import { AccueilPage } from '../pages/accueil/accueil';
import { CartesPage } from '../pages/cartes/cartes';

import { ProfilPage } from '../pages/profil/profil';
import { NotificationsPage } from '../pages/notifications/notifications';

import { TabsPage } from '../pages/tabs/tabs';
*/

@Component({
  templateUrl: 'app.html',
  providers: [LoginService]
})
export class MyApp {
  rootPage = LoginPage;
  infosActeur : any;

  constructor(platform: Platform, private loginService : LoginService) {
    platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();
    });
    this.infosActeur = loginService.getInfosActeur();
  }
}

