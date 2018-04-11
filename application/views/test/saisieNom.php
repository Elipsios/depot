<html>

    <body>

<?php

   /* Le contenu de notre formulaire va être posté

   à la méthode bonjourAvecSaisieNom du controleur Test  */

   echo form_open('Test/bonjourAvecSaisieNom');

   echo form_label('Entrez votre nom ','txtNom');

   echo form_input('txtNom');

   echo form_submit('submit', 'OK');

   echo form_close();

?>

</body>

</html>
