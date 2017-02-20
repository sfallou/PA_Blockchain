import {Component} from '@angular/core';
import {Validators, FormBuilder, FormGroup } from '@angular/forms';
import {NavController} from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
//import {MovieInfo} from '../movie-info/movie-info';

@Component({
    templateUrl: 'accueil.html',
    providers: [CirchainService]
})

export class AccueilPage {
 private acteur : FormGroup;
 private result : Array<any>;

  constructor( private formBuilder: FormBuilder, private navController: NavController, private infosActeur: CirchainService) {
    this.acteur = this.formBuilder.group({
      id: ['', Validators.required],
      mdp: [''],
    });
  }
  loginForm(){
    //console.log(this.acteur.value.mdp);
    this.infosActeur.authentification(this.acteur.value.id).subscribe(
				data => {
					this.result = data.data;
					//console.log(this.result['mdp']);
          if(this.result['mdp']===this.acteur.value.mdp){
               console.log("Connexion etablie");
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

/*
	itemTapped(event, movie) {
		console.log(movie);
		this.navController.push(MovieInfo, {
			movie: movie
		});
	}*/
}
