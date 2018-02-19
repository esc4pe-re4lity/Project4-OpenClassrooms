<?php ob_start(); ?>
<div id="header-box">
    <h1>
        <a href="index.php" title="Retour à l'accueil">
            BILLET SIMPLE POUR L'ALASKA
        </a>
    </h1>
    <a class="hover bold" href="index.php?action=login">Connexion</a>
</div>

<div id="banner">
    <div class="banner" id="logout">
        <p>
            Vous êtes déconnecté
        </p>
    </div>
</div>
<?php $header = ob_get_clean(); ?>