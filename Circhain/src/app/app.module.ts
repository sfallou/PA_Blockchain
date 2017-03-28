import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

import { LoginPage } from '../pages/login/login';
import { AccueilPage } from '../pages/accueil/accueil';
import { CartesPage } from '../pages/cartes/cartes';
import { CarteDetailsPage } from '../pages/carte-details/carte-details';
import { ProfilPage } from '../pages/profil/profil';
import { NotificationsPage } from '../pages/notifications/notifications';
import { ScanPage } from '../pages/scan/scan';
import { InfosPage } from '../pages/infos/infos';
import { TabsPage } from '../pages/tabs/tabs';

@NgModule({
  declarations: [
    MyApp,
    LoginPage,
    AccueilPage,
    CartesPage,
    CarteDetailsPage,
    NotificationsPage,
    ProfilPage,
    ScanPage,
    InfosPage,
    TabsPage
  ],
  imports: [
    IonicModule.forRoot(MyApp,{tabsPlacement: 'top', tabsHideOnSubPages:"true"}) 
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    LoginPage,
    AccueilPage,
    CartesPage,
    CarteDetailsPage,
    NotificationsPage,
    ProfilPage,
    ScanPage,
    InfosPage,
    TabsPage
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}]
})
export class AppModule {}
