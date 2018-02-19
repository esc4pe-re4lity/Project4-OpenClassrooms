<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>BLOG</h1>
<p>
    Bonjour <?= ucfirst(htmlspecialchars($user->getPseudo())) ?><br/>
</p>
<nav>
    <ul>
        <li><a href="index.php?action=updateUser">Modifier votre profil</a></li>
        <li><a href="index.php?action=addPost">Ajouter un post</a></li>
        <li><a href="index.php?action=getReportedComments">Afficher les commentaires signalés</a></li>
        <li><a href="index.php">Retour à l'accueil</a></li>
        <li><a href="index.php?action=logout">Déconnexion</a></li>
    </ul>
</nav>
<?php $header = ob_get_clean(); ?>


<?php ob_start()?>
<form method="post" action="index.php?action=updateUser">
    <p>
        Mot de passe actuel : 
        <input type="password" name="password" value="" required/>
        <br/>
        Nouveau mot de passe : 
        <input type="password" name="email" value="" required/>
        Confirmation : 
        <input type="password" name="pseudo" value="" required/>
        <br/>
    </p>
    <p><input type="submit" value="Enregistrer les modifications"/></p>
</form>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script src="../public/js/functions.js"></script>
<script>

</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>