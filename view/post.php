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
while ($data = $post->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="posts">
    <h2><?= htmlspecialchars(utf8_encode(($data['title']))) ?></h2>
    <p>
        <?= nl2br(htmlspecialchars(utf8_encode($data['content']))) ?>
        <br/>
        <span class="date"><?= $data['creationDate'] ?></span>
    </p>
</div>
<?php
}
?>
<form class="add_comment" method="post" action="index.php?action=addComment&idPost=<?= $data['id']; ?>">
    <p>
        <input type="texte" name="author" placeholder="Pseudo" required/>
        <br/>
        <textarea name="comment" placeholder="Ecrivez votre commentaire" required></textarea>
    </p>
    <p><input type="submit" value="Envoyer"/></p>
</form>

<?php
while ($comment = $comments->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="comments">
    <h3><?= htmlspecialchars(utf8_encode($comment['author'])) ?></h3>
    <p>
        <?= nl2br(htmlspecialchars(utf8_encode($comment['content']))) ?>
        <br/>
        <span class="date"><?= $comment['creationDate'] ?></span>
    </p>
</div>
<?php
}
?>
<?php $section = ob_get_clean(); ?>

<?php require('template.php'); ?>