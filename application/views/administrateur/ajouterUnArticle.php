<h2><?php echo $TitreDeLaPage ?></h2>

<?php echo validation_errors();

echo form_open('administrateur/ajouterUnArticle') ?>

<label for="txtTitre">Titre de l'article</label>
<input type="input" name="txtTitre" value="<?php echo set_value('txtTitre'); ?>" /><br/>

<label for="txtTexte">Texte de l'article</label>
<textarea name="txtTexte" value="<?php echo set_value('txtTexte'); ?>"></textarea><br/>

<label for="txtNomFichierImage">Nom du fichier Image</label>
<input type="input" name="txtNomFichierImage" value="<?php echo set_value('txtNomFichierImage'); ?>" /><br/>

<input type="submit" name="submit" value="Ajouter un article" />

</form>
