import {Component} from '@angular/core';
import {NavController} from 'ionic-angular';
import {EcoleService} from '../mesServices/test';
//import {MovieInfo} from '../movie-info/movie-info';

@Component({
    templateUrl: 'accueil.html',
    providers: [EcoleService]
})

export class AccueilPage {

	ecoles: Array<any>;

    constructor(private navController: NavController, private ecoleService: EcoleService) {
      this.getEcoles();

    }

	getEcoles() {
			this.ecoleService.searchEcoles().subscribe(
				data => {
					this.ecoles = data.data;
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
