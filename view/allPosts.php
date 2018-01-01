<?php $title = 'Mon blog'; ?>

<?php ob_start(); ?>
<h1>BLOG</h1>
<p>
    <a href="index.php?action=login">Connexion</a><br/>
    <a href="index.php?action=createAccount">Inscription</a>
</p>
<?php $header = ob_get_clean(); ?>

<?php ob_start(); ?>
<?php
while ($post = $posts->fetch(PDO::FETCH_ASSOC))
{
?>
    <div class="posts">
        <h2><?= htmlspecialchars(utf8_encode($post['title'])) ?></h2>
        <p>
            <?= nl2br(htmlspecialchars(utf8_encode($post['content']))) ?>
            <br />
            <span class="date"><?= $post['creationDate'] ?></span>
            <a href="index.php?action=post&amp;id=<?= $post['id'] ?>">Commentaires</a>
        </p>
    </div>
<?php
}
?>
<?php $section = ob_get_clean(); ?>

<?php require('template.php'); ?>