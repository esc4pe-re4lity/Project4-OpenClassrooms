<?php $title = 'Billet simple pour l\'Alaska - Connexion'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<form class="login" method="post" action="index.php?action=login">
    <p>
        <label for="pseudo">Pseudo</label>
        <br/>
        <input type="texte" name="pseudo" id="pseudo" required/>
    </p>
    <p>
        <label for="password">Mot de passe</label>
        <br/>
        <input type="password" name="password" id="password" required/>
    </p>
    <p>
        <input class="button" type="submit" value="Connexion"/>
    </p>
    <p>Vous n'êtes pas encore membre ? Cliquez <a class="hover bold" href="index.php?action=createAccount">ici</a></p>
</form>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    <?php if(isset($displayBanner)){
        echo htmlspecialchars($displayBanner);
    } ?>
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>