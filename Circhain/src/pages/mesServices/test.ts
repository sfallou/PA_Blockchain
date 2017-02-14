import {Http} from '@angular/http';
import 'rxjs/add/operator/map';

export class EcoleService {
static get parameters() {
        return [[Http]];
    }

    constructor(private http:Http) {

    }

    searchEcoles() {
        var url = 'http://challenge2016.eclair.ec-lyon.fr/api/ecoles';
        var response = this.http.get(url).map(res => res.json());
        return response;
    }
}
