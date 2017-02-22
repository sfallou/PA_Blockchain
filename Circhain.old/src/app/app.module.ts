import { NgModule, ErrorHandler } from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';
//import { MesServices } from '../pages/mesServices/mesServices';
//import { EcoleService } from '../pages/mesServices/test';
import { LoginPage } from '../pages/login/login';
import { AccueilPage } from '../pages/accueil/accueil';
import { CartesPage } from '../pages/cartes/cartes';
import { CarteDetailsPage } from '../pages/carte-details/carte-details';
import { ProfilPage } from '../pages/profil/profil';
import { NotificationsPage } from '../pages/notifications/notifications';


@NgModule({
  declarations: [
    MyApp,
    //MesServices,
    //EcoleService,
    LoginPage,
    AccueilPage,
    CartesPage,
    CarteDetailsPage,
    NotificationsPage,
    ProfilPage

  ],
  imports: [
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    //MesServices,
    //EcoleService,
    LoginPage,
    AccueilPage,
    CartesPage,
    CarteDetailsPage,
    NotificationsPage,
    ProfilPage
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}]
})
export class AppModule {}
