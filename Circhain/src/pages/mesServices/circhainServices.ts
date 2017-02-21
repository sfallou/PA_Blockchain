import {Http} from '@angular/http';
import 'rxjs/add/operator/map';

export class CirchainService {
static get parameters() {
        return [[Http]];
    }

    constructor(private http:Http) {

    }

    authentification(id,pass) {
        var url = 'http://challenge2016.eclair.ec-lyon.fr/circhain/api/acteur/auth';
        var data = JSON.stringify({id_acteur: id, mdp: pass });
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    mesCartes(id,pass) {
        var url = 'http://challenge2016.eclair.ec-lyon.fr/circhain/api/acteur/mes/cartes';
        var data = JSON.stringify({id_acteur: id, mdp: pass });
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    historiqueCarte(id_acteur,id_carte) {
        var url = 'http://challenge2016.eclair.ec-lyon.fr/circhain/api/acteur/scanner/carte';
        var data = JSON.stringify({id_acteur: id_acteur, id_carte: id_carte});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }
}
