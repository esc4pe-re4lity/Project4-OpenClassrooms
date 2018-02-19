<?php ob_start(); ?>
<div id="header-box">
    <h1>
        <a href="index.php" title="Retour à l'accueil">
            BILLET SIMPLE POUR L'ALASKA
        </a>
    </h1>
    <div id='user-menu'>
        <div id="icon-menu">
            <div id="icon-user">
                <i class="fa fa-user-circle"></i>
            </div>
            <span id="arrow-down"></span>
        </div>
        <nav id="nav-menu">
            <ul>
                <li>
                    Bienvenue <?= ucfirst(htmlspecialchars($user->getPseudo())) ?>
                </li>
                <li>
                    <a href="index.php?action=updateUser">
                        <i class="fa fa-user"></i>
                        Modifier mon profil
                    </a>
                </li>
                <li>
                    <a href="index.php?action=addPost">
                        <i class="fa fa-edit"></i>
                        Nouveau post
                    </a>
                </li>
                <li>
                    <a href="index.php?action=getReportedComments">
                        <i class="fa fa-flag"></i>
                        Commentaires signalés
                    </a>
                </li>
                <li>
                    <a href="index.php?action=logout">
                        <i class="fa fa-power-off"></i>
                        Déconnexion
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<div id="banner">
    <div class="banner" id="deletePost">
        <p>
            L'article a bien été supprimé 
        </p>
    </div>
    <div class="banner" id="deleteComment">
        <p>
            Le commentaire a bien été supprimé 
        </p>
    </div>
    <div class="banner" id="createAccount">
        <p>
            Bienvenue <?= ucfirst(htmlspecialchars($user->getPseudo())) ?> !<br/>
            Un e-mail de confirmation vous a été envoyé
        </p>
    </div>
    <div class="banner" id="updateUser">
        <p>
            Vos informations personnelles ont bien modifiées
        </p>
    </div>
    <div class="banner" id="login">
        <p>
            Bienvenue <?= ucfirst(htmlspecialchars($user->getPseudo())) ?> !<br/>
            Vous êtes connecté
        </p>
    </div>
    <div class="banner" id="logout">
        <p>
            Vous êtes déconnecté
        </p>
    </div>
</div>
<?php $header = ob_get_clean(); ?>