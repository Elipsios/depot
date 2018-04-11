<?php

class Test extends CI_Controller

{
public function bonjourAvecParametre($nom = 'Anonyme')
{
$DonneesInjectees['nomDeLaPersonne'] = $nom;
$this->load->view('test/bonjourAvecParametre',$DonneesInjectees); // injection du tableau

}

public function bonjourSimple()
{
$this->load->view('test/bonjourSimple'); // appel de la vue... pas d'affichage dans le controleur
}

public function saisieNom() // appel du formulaire de saisie du nom
{
$this->load->helper('form');
// on va utiliser des fonctions - du helper form - pour générer le formulaire (vue 'saisieNom')
$this->load->view('test/saisieNom');
}

public function bonjourAvecSaisieNom() // traitement du retour du formulaire
{
$DonneesInjectees['nomDeLaPersonne'] = $this->input->post('txtNom');
$this->load->view('test/bonjourAvecParametre',$DonneesInjectees);
}
}
?>
