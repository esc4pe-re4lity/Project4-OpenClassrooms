<?php $title = 'Billet simple pour l\'Alaska - Modification informations personnelles'; ?>


<?php require('header.php'); ?>


<?php ob_start()?>
<div class="box">
    <h2>Mon profil</h2>
    <div id="userProfil">
        <div class="button">
            <a href="#" class="updateUser">Modifier</a>
        </div>
        <h3>
            <?= ucfirst(htmlspecialchars($user->getPseudo()))?>
        </h3>
        <p>
            <?=htmlspecialchars($user->getEmail())?>
        </p>
    </div>
    <div id="userUpdateForm" style="display: none;">
        <form method="post" action="index.php?action=updateUser">
            <p>
                <label for="pseudo">Pseudo : </label>
                <input type="texte" name="pseudo" id="pseudo" value="<?=htmlspecialchars($user->getPseudo())?>" required/>
            </p>
            <p>
                <label for="email">Email : </label>
                <input type="texte" name="email" id="email" value="<?=htmlspecialchars($user->getEmail())?>" required/>
            </p>
            <p>
                <label for="password">Créez un mot de passe</label>
                <input type="password" name="password" id="password" required/>
            </p>
            <p>
                <label for="confirmPassword">Confirmez votre mot de passe</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required/>
            </p>
            <p><input class="button" type="submit" value="Enregistrer les modifications"/></p>
        </form>
    </div>
</div>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    $('a').filter('[class="updateUser"]').click(function(){
        document.getElementById("userProfil").style = "display: none;";
        document.getElementById("userUpdateForm").style = "display: initial;";
    });
    document.getElementById("pseudo").addEventListener("change", verifyPseudo);
    document.getElementById("email").addEventListener("change",verifyEmail);
    document.getElementById("password").addEventListener("input",verifyPassword);
    document.getElementById("confirmPassword").addEventListener("change", verifyConfPassword);
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