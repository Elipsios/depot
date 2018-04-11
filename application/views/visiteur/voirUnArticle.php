<?php
echo '<h2>'.$unArticle['cTitre'].'</h2>';
echo $unArticle['cTexte'];
echo '<p>'.img($unArticle['cNomFichierImage']).'<p>'; // Affiche directement l'image
// Nota Bene : img_url($unArticle['cNomFichierImage']) aurait retourne l'url de l'image (cf. assets)
echo '<p>'.anchor('visiteur/listerLesArticles','Retour à la liste des articles').'</p>';
