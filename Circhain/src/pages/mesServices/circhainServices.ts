import {Http} from '@angular/http';
import 'rxjs/add/operator/map';

export class CirchainService {
static get parameters() {
        return [[Http]];
    }

    constructor(private http:Http) {

    }

    authentification(id) {
        var url = 'http://challenge2016.eclair.ec-lyon.fr/circhain/api/acteur';
        var data = JSON.stringify({id_acteur: id});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }
}
