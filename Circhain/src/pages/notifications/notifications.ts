import { Component } from '@angular/core';
import { NavController, NavParams} from 'ionic-angular';
import { AlertController } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-notifications',
  templateUrl: 'notifications.html',
  providers: [CirchainService]
})
export class NotificationsPage {
  selectedItem: any;
  acteur : any;
  status : any;
  result : any;
  nb_msg_unread : any;
  messages_envoyes : any;
  messages_recus : any;


   constructor(public navCtrl: NavController,
               public navParams: NavParams,
               public alertCtrl: AlertController,
               private loginService: LoginService,
               private infosActeur: CirchainService
               ){
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.infosActeur.mesNotifications(this.acteur['id_acteur'],this.acteur['mdp']).subscribe(
        data => {
          this.status = data.status;
          this.result = data.data;
          this.nb_msg_unread = this.result['nombre_message_non_lus'];
          this.messages_envoyes = this.result['messages_envoyes'];
          this.messages_recus = this.result['messages_recus'];
          
        },
        err => {
          console.log(err);
        }
      );
  }

  itemTapped(event, item) {
    console.log(item['id_notification']);
    console.log(item['etat_notification']);
    console.log(this.acteur['id_acteur']);
    //on fait appel à la methode lireNotification si le message n'a jamais été lu
    if(item['etat_notification']==0){
      this.infosActeur.lireNotification(item['id_notification'],item['etat_notification'],this.acteur['id_acteur']).subscribe(
        data => {
          this.status = data.status;
          this.result = data.data;
          if(this.status === "OK"){
            console.log(this.result);
            //var nb = this.acteur['nombre_message_non_lus']-1;
            //this.loginService.setIndicateurMessage(nb);
            //this.messages_recus = this.acteur['messages_recus'];
          }
          else
            console.log("Not read");
        },
        err => {
          console.log(err);
        }
      );

    }
    // on crée un popup
   let alert = this.alertCtrl.create({
      title: "Notification",
      subTitle: "La carte n° : "+item['id_carte_concernee']+" a été " +item['type_notification']+" par " +item['id_emetteur']+" le "+ item['date_envoi'],
      buttons: ['OK']
    });
    alert.present();
  }

  itemTapped2(event, item) {
   let alert = this.alertCtrl.create({
      title: "Notification",
       //subTitle: "Vous avez " +item['type_notification']+" la carte n° : "+item['id_carte_concernee']+" à " +item['id_destinataire']+" le "+ item['date_envoi'],
      subTitle: "La carte n° " +item['id_carte_concernee']+" envoyée par " +item['id_destinataire']+" a été "+ item['type_notification'] +" le  "+item['date_envoi'],
      buttons: ['OK']
    });
    alert.present();
  }
}

