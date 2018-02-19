<?php $title = 'Billet simple pour l\'Alaska - Modification informations personnelles'; ?>


<?php require('header.php'); ?>


<?php ob_start()?>
<form method="post" action="index.php?action=updateUser">
    <h2>Mon profil</h2>
    <p>
        <label for="pseudo">Pseudo : </label>
        <input type="texte" name="pseudo" id="pseudo" value="<?=htmlspecialchars($user->getPseudo())?>" required/>
    </p>
    <p>
        <label for="email">Email : </label>
        <input type="texte" name="email" id="email" value="<?=htmlspecialchars($user->getEmail())?>" required/>
    </p>
    <p><input class="button" type="submit" value="Enregistrer les modifications"/></p>
</form>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    document.getElementById("pseudo").addEventListener("change", verifyPseudo);
    document.getElementById("email").addEventListener("change",verifyEmail);
    document.querySelector("form").addEventListener("submit", function(e){
        var formOK = verifyForm();
        if(formOK === false){
            e.preventDefault();
            formNOK();
        }
    });
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>