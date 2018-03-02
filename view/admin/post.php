<?php $title = 'Billet simple pour l\'Alaska - Article'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<div class="admin-posts">
    <div class="posts">
        <div class="post-title">
            <h2><?= htmlspecialchars(utf8_encode(($post->getTitle()))) ?></h2>
            <div class="admin-toolbar">
                <div class="font-awesome-icons button">
                    <a href="index.php?action=updatePost&amp;id=<?=$post->getId()?>" title="Modifier">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="font-awesome-icons button">
                    <a href="index.php?action=deletePost&amp;id=<?=$post->getId()?>" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="post-content">
            <p>
                <?=nl2br(utf8_encode($post->getContent()))?>
            </p>
            <p>
                <time class="date">
                    <?php 
                    if($post->getUpdated() == true){
                        echo $post->getCreationDate();
                    }else{
                        echo $post->getUpdatedDate();
                    }?>
                </time>
            </p>
        </div>
    </div>
</div>
<form class="add-comment" method="post" action="index.php?action=addComment&idPost=<?= $post->getId() ?>">
    <p>
        <textarea name="content" placeholder="Ecrivez votre commentaire" required></textarea>
    </p>
    <p><input class="button" type="submit" value="Envoyer"/></p>
</form>
<?php
foreach ($comments as $comment)
{
?>
<div class="comments">
    <h3><?= ucfirst(htmlspecialchars(utf8_encode($comment->getAuthor()))) ?></h3>
    <p>
        <?= nl2br(htmlspecialchars(utf8_encode($comment->getContent()))) ?>
    </p>
    <p>
        <time class="date">
            <?= $comment->getCreationDate()?>
        </time>
    </p>
</div>
<?php
}
?>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    $('a').filter('[title="Supprimer"]').click(confirmDelete);
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>