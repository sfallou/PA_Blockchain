import { Component } from '@angular/core';
import { NavController, NavParams, ViewController } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';

@Component({
  selector: 'page-infos',
  templateUrl: 'infos.html',
})
export class InfosPage {
A: string = this.navParams.get('A');
B: string = this.navParams.get('B');
C: string = this.navParams.get('C');
D: string = this.navParams.get('D');
E: string = this.navParams.get('E');
Vide: string = this.navParams.get('Vide');

  constructor(public navParams: NavParams, public viewCtrl: ViewController) {
    //console.log(this.B);
  }

  // ...
  closeModal() {
    this.viewCtrl.dismiss();
  }
}


