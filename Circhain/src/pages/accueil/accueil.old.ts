import {Component} from '@angular/core';
import {NavController} from 'ionic-angular';
import {CirchainService} from '../mesServices/circhainServices';
//import {MovieInfo} from '../movie-info/movie-info';

@Component({
    templateUrl: 'accueil.html',
    providers: [CirchainService]
})

export class AccueilPage {

	acteur: Array<any>;

    constructor(private navController: NavController, private infosActeur: CirchainService) {
      this.getActeur("CCIIRRLLYY");

    }

	getActeur(id) {
			this.infosActeur.authentification(id).subscribe(
				data => {
					this.acteur = data.data;
					console.log(data);
				},
				err => {
					console.log(err);
				},
				() => console.log('Rien trouve')
			);

	}

	/*itemTapped(event, movie) {
		console.log(movie);
		this.navController.push(MovieInfo, {
			movie: movie
		});
	}*/
}
