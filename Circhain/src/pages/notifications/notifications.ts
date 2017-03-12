import { Component } from '@angular/core';
import { NavController} from 'ionic-angular';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-notifications',
  templateUrl: 'notifications.html'
})
export class NotificationsPage {
  acteur : any;

  nb_msg_unread : any;
  messages_envoyes : any;
  messages_recus : any;


   constructor(public navCtrl: NavController,private loginService: LoginService)
  {

    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    this.nb_msg_unread = this.acteur['nombre_message_non_lus'];
    this.messages_envoyes = this.acteur['messages_envoyes'];
    this.messages_recus = this.acteur['messages_recus'];
  }
}

