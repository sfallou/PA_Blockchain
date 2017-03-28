import {Component} from '@angular/core';
import {Validators, FormBuilder, FormGroup } from '@angular/forms';
import {NavController, NavParams, AlertController} from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import { TabsPage } from '../tabs/tabs';

@Component({
    selector: 'page-login',
    templateUrl: 'login.html',
    providers: [CirchainService]
})

export class LoginPage {
 private acteur : FormGroup;
 private result : Array<any>;
 private status : String;

  constructor(private formBuilder: FormBuilder,
              private infosActeur: CirchainService,
              private navController: NavController,
              public alertCtrl: AlertController,
              private navParams: NavParams,
              private loginService: LoginService
              ) {
    this.acteur = this.formBuilder.group({
      id: ['', Validators.required],
      mdp: [''],
    });
  }
  loginForm(){
    //console.log(this.acteur.value.mdp);
    this.infosActeur.authentification(this.acteur.value.id,this.acteur.value.mdp).subscribe(
				data => {
					this.status = data.status;
					this.result = data.data;
          if(this.status === "OK"){
              var id = this.result['id_acteur'];
              var nom = this.result['nom'];
              var prenom = this.result['prenom'];
              var email = this.result['email'];
              var mdp = this.result['mdp'];
              var adresse = this.result['adresse'];
              var profil = this.result['profil'];
              /*var nb = this.result['nombre_message_non_lus'];
              var msg_send = this.result['messages_envoyes'];
              var msg_read = this.result['messages_recus'];*/
              var tel = this.result['tel'];
              this.loginService.setInfosActeur(id,nom,prenom,email,mdp,adresse,profil,tel);
              this.navController.setRoot(TabsPage );
            //console.log(this.loginService.getInfosActeur());
          }
          else{
              console.log("Wrong")
              }
				},
				err => {
					//console.log(err);
          let alert = this.alertCtrl.create({
                title: "Attention!",
                subTitle: "Les paramètres de connexion sont incorrects",
                buttons: ['OK']
              });
              alert.present();
				}
			);

  }


}
