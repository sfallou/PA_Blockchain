import {Http} from '@angular/http';
import 'rxjs/add/operator/map';

export class CirchainService {
static get parameters() {
        return [[Http]];
    }

    constructor(private http:Http) {

    }

    authentification(id,pass) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/auth';
        var data = JSON.stringify({id_acteur: id, mdp: pass });
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    mesCartes(id,pass) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/mes/cartes';
        var data = JSON.stringify({id_acteur: id, mdp: pass });
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    scannerCarte(id_acteur,id_carte) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/scanner/carte';
        var data = JSON.stringify({id_acteur: id_acteur, id_carte: id_carte});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    historiqueCarte(id_acteur,id_carte) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/historique/carte';
        var data = JSON.stringify({id_acteur: id_acteur, id_carte: id_carte});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

     mesNotifications(id,pass) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/mes/notifications';
        var data = JSON.stringify({id_acteur: id, mdp: pass });
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    lireNotification(id_notification,etat_notification,id_acteur) {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/lire/notification';
        var data = JSON.stringify({id_notification: id_notification, etat_notification: etat_notification ,id_acteur: id_acteur});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    envoyerCarte(id_acteur,id_destinataire,id_carte) {
        var url = ' http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteur/envoyer/carte';
        var data = JSON.stringify({id_acteur: id_acteur, id_destinataire:id_destinataire, id_carte: id_carte});
        var response = this.http.post(url,data).map(res => res.json());
        return response;
    }

    tousLesActeurs() {
        var url = 'http://challenge-2016.eclair.ec-lyon.fr/circhain/api/acteurs';
        var response = this.http.get(url).map(res => res.json());
        return response;
    }

}
