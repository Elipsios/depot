<h2><?php echo $TitreDeLaPage ?></h2>
<!--
$TitreDeLaPage : variable récupérée depuis le contrôleur
$lesArticles : variable récupérée depuis le contrôleur (en 'mode tableau associatif')
 -->
<?php foreach ($lesArticles as $unArticle):
     echo '<h3>'.anchor('visiteur/voirUnArticle/'.$unArticle['cNo'],$unArticle['cTitre']).'</h3>';
endforeach ?>
<p>Pour avoir afficher le détail d'un article, cliquer sur son titre</p>
