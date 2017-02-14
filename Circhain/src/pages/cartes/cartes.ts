import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

import { CarteDetailsPage } from '../carte-details/carte-details';


@Component({
  selector: 'page-cartes',
  templateUrl: 'cartes.html'
})
export class CartesPage {
  selectedItem: any;
  icons: string[];
  cartes: Array<{title: string, note: string, icon: string}>;

  constructor(public navCtrl: NavController, public navParams: NavParams)
  {
    // If we navigated to this page, we will have an item available as a nav param
    this.selectedItem = navParams.get('item');

    this.icons = ['flask', 'wifi', 'beer', 'football', 'basketball', 'paper-plane',
    'american-football', 'boat', 'bluetooth', 'build'];

    this.cartes = [];
    for(let i = 1; i < 11; i++) {
      this.cartes.push({
        title: 'Carte ' + i,
        note: 'This is card #' + i,
        icon: this.icons[Math.floor(Math.random() * this.icons.length)]
      });
    }
  }

  itemTapped(event, item) {
    this.navCtrl.push(CarteDetailsPage, {
      item: item
    });
  }
}
