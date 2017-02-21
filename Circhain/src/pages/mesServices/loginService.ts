export class LoginService {

  id_acteur: string;
  nom_acteur: string;
  prenom_acteur: string;
  email: string;
  mdp: string;
  adresse: string;
  profil: string;
  tel: string;

constructor() {
        this.id_acteur = '';
        this.nom_acteur = '';
        this.prenom_acteur = '';
        this.email = '';
        this.mdp = '';
        this.adresse = '';
        this.profil = '';
        this.tel = '';
    }

    setInfosActeur(id,nom,prenom,email,mdp,adresse,profil,tel) {
        this.id_acteur = id;
        this.nom_acteur = nom;
        this.prenom_acteur = prenom;
        this.email = email;
        this.mdp = mdp;
        this.adresse = adresse;
        this.profil = profil;
        this.tel = tel;
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
            tel : this.tel
          });
        return data;
    }
}
