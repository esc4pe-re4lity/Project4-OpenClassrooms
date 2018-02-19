<?php $title = 'Billet simple pour l\'Alaska - Nouveau compte'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<form class="login" method="post" action="index.php?action=createAccount">
    <p>
        <label for="pseudo">Pseudo</label>
        <br/>
        <input type="text" name="pseudo" id="pseudo" required/>
    </p>
    <p>
        <label for="email">Email</label>
        <br/>
        <input type="text" name="email" id="email" required/>
    </p>
    <p>
        <label for="password">Créez un mot de passe</label>
        <br/>
        <input type="password" name="password" id="password" required/>
    </p>
    <p>
        <label for="confirmPassword">Confirmez votre mot de passe</label>
        <br/>
        <input type="password" name="confirmPassword" id="confirmPassword" required/>
    </p>
    <p>
        <span id="info"></span>
    </p>
    <p>
        <input class="button" type="submit" value="Envoyer"/>
    </p>
    <p>Vous avez déjà un compte ? Cliquez <a class="hover bold" href="index.php?action=login">ici</a></p>
</form>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script src="../public/js/functions.js"></script>
<script>
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