<?php
class Administrateur extends CI_Controller
{

  public function __construct()
  {
     parent::__construct();
     $this->load->model('ModeleArticle');

     /* les méthodes du contrôleur Administrateur doivent n'être
     accessibles qu'à l'administrateur (Nota Bene : a chaque appel
     d'une méthode d'Administrateur on a appel d'abord du constructeur */
     $this->load->library('session');
     if ($this->session->statut==0) // 0 : statut visiteur
     {
        $this->load->helper('url'); // pour utiliser redirect
        redirect('/visiteur/seConnecter'); // pas les droits : redirection vers connexion
     }
  } // __construct

  public function ajouterUnArticle()
  {
      $this->load->helper('form');
      $this->load->library('form_validation');

      $DonneesInjectees['TitreDeLaPage'] = 'Ajouter un article';

      // Ci-dessous on 'pose' les règles de validation
      $this->form_validation->set_rules('txtTitre', 'Titre', 'required');
      $this->form_validation->set_rules('txtTexte', 'Texte', 'required');
      // l'image n'est pas obligatoire : pas required

      if ($this->form_validation->run() === FALSE)
      {   // formulaire non validé, on renvoie le formulaire
        $this->load->view('templates/Entete');
        $this->load->view('administrateur/ajouterUnArticle', $DonneesInjectees);
        $this->load->view('templates/PiedDePage');
      }
      else
      {
        $donneesAInserer = array(
          'cTitre' => $this->input->post('txtTitre'),
          'cTexte' => $this->input->post('txtTexte'),
          'NomImage' => $this->input->post('txtNomFichierImage')
          ); // cTitre, cTexte, NOMIMAGE : champs de la table tabarticle
          $this->ModeleArticle->insererUnArticle($donneesAInserer); // appel du modèle
          $this->load->helper('url'); // helper chargé pour utilisation de site_url (dans la vue)
          $this->load->view('administrateur/insertionReussie');
      }
  } // ajouterUnArticle
}
