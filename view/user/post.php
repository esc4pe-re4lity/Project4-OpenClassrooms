<?php $title = 'Billet simple pour l\'Alaska - Article'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<div class="posts">
    <div class="post-title">
        <h2><?= htmlspecialchars(utf8_encode(($post->getTitle()))) ?></h2>
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
    <div class="comment-title">
        <h3><?= ucfirst(htmlspecialchars(utf8_encode($comment->getAuthor()))) ?></h3>
        <div class="admin-toolbar flag">
            <div class="font-awesome-icons button">
                <a href="index.php?action=reportComment&amp;idPost=<?=$comment->getIdPost()?>&amp;id=<?=$comment->getId()?>">
                    <i class="fa fa-flag" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="comment-content">
        <p>
            <?= nl2br(htmlspecialchars(utf8_encode($comment->getContent()))) ?>
        </p>
        <p>
            <time class="date">
                <?= $comment->getCreationDate()?>
            </time>
        </p>
    </div>
</div>
<?php
}
?>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>