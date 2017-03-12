export class LoginService {

  id_acteur: string;
  nom_acteur: string;
  prenom_acteur: string;
  email: string;
  mdp: string;
  adresse: string;
  profil: string;
  tel: string;
  nombre_message_non_lus: any;
  messages_envoyes: any;
  messages_recus: any;

constructor() {
        this.id_acteur = '';
        this.nom_acteur = '';
        this.prenom_acteur = '';
        this.email = '';
        this.mdp = '';
        this.adresse = '';
        this.profil = '';
        this.tel = '';
        this.nombre_message_non_lus = '';
        this.messages_envoyes = '';
        this.messages_recus = '';

    }

    setInfosActeur(id,nom,prenom,email,mdp,adresse,profil,tel,nb,msg_send,msg_read) {
        this.id_acteur = id;
        this.nom_acteur = nom;
        this.prenom_acteur = prenom;
        this.email = email;
        this.mdp = mdp;
        this.adresse = adresse;
        this.profil = profil;
        this.tel = tel;
        this.nombre_message_non_lus = nb;
        this.messages_envoyes = msg_send;
        this.messages_recus = msg_read;
    }

    getInfosActeur() {
        var data = JSON.stringify(
          {
            id_acteur: this.id_acteur,
            nom_acteur : this.nom_acteur,
            prenom_acteur : this.prenom_acteur,
            email : this.email,
            mdp : this.mdp,
            adresse : this.adresse,
            profil : this.profil,
            tel : this.tel,
            nombre_message_non_lus: this.nombre_message_non_lus,
            messages_envoyes: this.messages_envoyes,
            messages_recus: this.messages_recus
          });
        return data;
    }

    setIndicateurMessage(new_indic){
      this.nombre_message_non_lus = new_indic;
    }
}
