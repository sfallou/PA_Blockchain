import {Component} from '@angular/core';
import {Validators, FormBuilder, FormGroup } from '@angular/forms';
import {NavController, NavParams} from 'ionic-angular';
//import {CryptoJS} from '@types/cryptojs';
import {CirchainService} from '../mesServices/circhainServices';
import {LoginService} from '../mesServices/loginService';
import {AccueilPage} from '../accueil/accueil';
@Component({
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
              var tel = this.result['tel'];
              this.loginService.setInfosActeur(id,nom,prenom,email,mdp,adresse,profil,tel);
              this.navController.setRoot(AccueilPage );
            //console.log(this.loginService.getInfosActeur());
          }
          else{
              console.log("Connexion non etablie");
              }
				},
				err => {
					console.log(err);
				}
			);

  }


}
