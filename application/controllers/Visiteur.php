<?php
class Visiteur extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->helper('url');
      $this->load->helper('assets'); // helper 'assets' ajouté a Application
      $this->load->library("pagination");
      $this->load->model('ModeleArticle'); // chargement modèle, obligatoire
      $this->load->model('ModeleUtilisateur');
   } // __construct

   public function listerLesArticles() // lister tous les articles
   {
      $DonneesInjectees['lesArticles'] = $this->ModeleArticle->retournerArticles();
      $DonneesInjectees['TitreDeLaPage'] = 'Tous les articles';

      $this->load->view('templates/Entete');
      $this->load->view('visiteur/listerLesArticles', $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
   } // listerLesArticles
   public function voirUnArticle($noArticle = NULL) // valeur par défaut de noArticle = NULL
   {
     $DonneesInjectees['unArticle'] = $this->ModeleArticle->retournerArticles($noArticle);
     if (empty($DonneesInjectees['unArticle']))
     {  // pas d'article correspondant au n°
       show_404();
     }

      $DonneesInjectees['TitreDeLaPage'] = $DonneesInjectees['unArticle']['LIBELLE'];
      // ci-dessus, entrée ['cTitre'] de l'entrée ['unArticle'] de $DonneesInjectees

      $this->load->view('templates/Entete');
      $this->load->view('visiteur/VoirUnArticle', $DonneesInjectees);
      $this->load->view('templates/PiedDePage');
    } // voirUnArticle

    public function seConnecter()

{
   $this->load->helper('form');
   $this->load->library('form_validation');

   $DonneesInjectees['TitreDeLaPage'] = 'Se connecter';

   $this->form_validation->set_rules('txtIdentifiant', 'Identifiant', 'required');
   $this->form_validation->set_rules('txtMotDePasse', 'Mot de passe', 'required');
   // Les champs txtIdentifiant et txtMotDePasse sont requis
   // Si txtMotDePasse non renseigné envoi de la chaine 'Mot de passe' requis

   if ($this->form_validation->run() === FALSE)
   {  // échec de la validation
     // cas pour le premier appel de la méthode : formulaire non encore appelé
     $this->load->view('templates/Entete');
     $this->load->view('visiteur/seConnecter', $DonneesInjectees); // on renvoie le formulaire
     $this->load->view('templates/PiedDePage');
   }
   else
   {  // formulaire validé
     $Utilisateur = array( // cIdentifiant, cMotDePasse : champs de la table tabutilisateur
       'cIdentifiant' => $this->input->post('txtIdentifiant'),
       'cMotDePasse' => $this->input->post('txtMotDePasse'),
     ); // on récupère les données du formulaire de connexion

     // on va chercher l'utilisateur correspondant aux Id et MdPasse saisis
     $UtilisateurRetourne = $this->ModeleUtilisateur->retournerUtilisateur($Utilisateur);
     if (!($UtilisateurRetourne == null))
     {    // on a trouvé, identifiant et statut (droit) sont stockés en session
       $this->load->library('session');
       $this->session->identifiant = $UtilisateurRetourne->cIdentifiant;
       $this->session->statut = $UtilisateurRetourne->cStatut;

       $DonneesInjectees['Identifiant'] = $Utilisateur['cIdentifiant'];
       $this->load->view('templates/Entete');
       $this->load->view('visiteur/connexionReussie', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
     else
     {    // utilisateur non trouvé on renvoie le formulaire de connexion
       $this->load->view('templates/Entete');
       $this->load->view('visiteur/seConnecter', $DonneesInjectees);
       $this->load->view('templates/PiedDePage');
     }
   }
 } // fin seConnecter

 public function seDeConnecter() { // destruction de la session = déconnexion
    $this->session->sess_destroy();
}

// affichage avec pagination
public function listerLesArticlesAvecPagination() {
   // les noms des entrées dans $config doivent être respectés
   $config = array();
   $config["base_url"] = site_url('visiteur/listerLesArticlesAvecPagination');
   $config["total_rows"] = $this->ModeleArticle->nombreDArticles();
   $config["per_page"] = 3; // nombre d'articles par page
   $config["uri_segment"] = 3; /* le n° de la page sera placé sur le segment n°3 de URI,
   pour la page 4 on aura : visiteur/listerLesArticlesAvecPagination/4   */

   $config['first_link'] = 'Premier';
   $config['last_link'] = 'Dernier';
   $config['next_link'] = 'Suivant';
   $config['prev_link'] = 'Précédent';

   $this->pagination->initialize($config);

   $noPage = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
   /* on récupère le n° de la page - segment 3 - si ce segment est vide, cas du premier appel
   de la méthode, on affecte 0 à $noPage */

   $DonneesInjectees['TitreDeLaPage'] = 'Les articles, avec pagination';
   $DonneesInjectees["lesArticles"] = $this->ModeleArticle->retournerArticlesLimite($config["per_page"], $noPage);
   $DonneesInjectees["liensPagination"] = $this->pagination->create_links();

   $this->load->view('templates/Entete');
   $this->load->view("visiteur/listerLesArticlesAvecPagination", $DonneesInjectees);
   $this->load->view('templates/PiedDePage');
} // fin listerLesArticlesAvecPagination

}  // Visiteur
