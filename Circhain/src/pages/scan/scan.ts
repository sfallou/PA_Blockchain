import { Component } from '@angular/core';
import { NavController, NavParams, AlertController } from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import { CarteDetailsPage } from '../carte-details/carte-details';
import { TabsPage } from '../tabs/tabs';

@Component({
  selector: 'page-scan',
  templateUrl: 'scan.html',
  providers: [CirchainService]
})
export class ScanPage {
  carte: any;
  acteur : any;
  result : any;
  status : any;
  id_carte :any;
  proprietaire : any;
  //-----------//
  testCheckboxOpen: boolean;
  testCheckboxResult;
  lesActeurs : any;

  constructor(public navCtrl: NavController,
              public navParams: NavParams,
              public alertCtrl: AlertController,
              private circhainService: CirchainService, 
              private loginService: LoginService
              ){
    // If we navigated to this page, we will have an item available as a nav param
    this.carte = navParams.get('carte');
    this.id_carte = this.carte['id_carte'];
    this.proprietaire = this.carte['proprietaire_actuel'];
    //console.log(this.carte);
    this.acteur = JSON.parse(this.loginService.getInfosActeur());
    
}
  
  toSend() {
    // On récupère les acteurs
    this.circhainService.tousLesActeurs().subscribe(
        data => {
          this.status = data.status;
          this.result = data.data;
          // On crée le popub avec les choix possible
          let alert = this.alertCtrl.create();
          alert.setTitle('Envoyer cette carte à ...');
          for (let user of this.result) {
            if(user['id_acteur']!==this.proprietaire){
            alert.addInput({
            type: 'radio',
            label: user['id_acteur'],
            value: user['id_acteur'],
            //checked: true
            });
           }
          }
          alert.addButton('Cancel');
          alert.addButton({
            text: 'Send',
            handler: data => {
              this.testCheckboxOpen = false;
              this.testCheckboxResult = data;
              if(this.testCheckboxResult == null){
                  console.log('Veuillez choisir une personne');
                }
              else{
                this.circhainService.envoyerCarte(this.proprietaire,this.testCheckboxResult,this.id_carte).subscribe(
                    data => {
                      //this.status = data.status;
                      //this.result = data.data;
                      if(data.status==="OK" && data.data==1){
                        console.log("ok");
                        let alert2 = this.alertCtrl.create();
                        alert2.setTitle("Confirmation");
                        alert2.setSubTitle("La carte a été envoyé à "+this.testCheckboxResult);
                        alert2.addButton({
                          text: 'Send',
                          handler: data => {
                            this.navCtrl.setRoot(TabsPage );
                          }
                        });
                        alert2.present();
              
                      }
                      else{
                        console.log("non");
                      }
                    },
                    err => {
                        console.log(err);
                       }
                     );
                }
              }
            });
          alert.present().then(() => {
            this.testCheckboxOpen = true;
          });
        },
        err => {
          console.log(err);
        }
      );
   
  }

  showHistory() {
   this.navCtrl.push(CarteDetailsPage, {
      item: this.carte
    });
  }

  toOrder() {
   let alert = this.alertCtrl.create({
     title: "Oops!",
     subTitle: "Cette fonctionnalité n'est pas encore disponible",
     buttons: ['OK']
   });
   alert.present();
             
  }
}
