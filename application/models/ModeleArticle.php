<?php
class ModeleArticle extends CI_Model {

public function __construct()
{
$this->load->database();
/* chargement database.php (dans config), obligatoirement dans le constructeur */
}

     public function retournerArticles($pNoArticle = FALSE)
     {
        if ($pNoArticle === FALSE) // pas de n° d'article en paramètre
        {  // on retourne tous les articles
             $requete = $this->db->get('produit');
             return $requete->result_array(); // retour d'un tableau associatif
        }
        // ici on va chercher l'article dont l'id est $pNoArticle
        $requete = $this->db->get_where('produit', array('NoProduit' => $pNoArticle));
        return $requete->row_array(); // retour d'un tableau associatif
     } // fin retournerArticles

     public function insererUnArticle($pDonneesAInserer)
          {
       return $this->db->insert('produit', $pDonneesAInserer);
     } // insererUnArticle

     public function retournerArticlesLimite($nombreDeLignesARetourner, $noPremiereLigneARetourner)
     {// Nota Bene : surcharge non supportée par PHP
       $this->db->limit($nombreDeLignesARetourner, $noPremiereLigneARetourner);
       $requete = $this->db->get("produit");

       if ($requete->num_rows() > 0) { // si nombre de lignes > 0
         foreach ($requete->result() as $ligne) {
           $jeuDEnregsitrements[] = $ligne;
         }
         return $jeuDEnregsitrements;
       } // fin if
       return false;
     } // retournerArticlesLimite

     public function nombreDArticles() { // méthode utilisée pour la pagination
       return $this->db->count_all("produit");
     } // nombreDArticles

} // Fin Classe
