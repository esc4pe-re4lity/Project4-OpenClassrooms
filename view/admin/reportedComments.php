<?php $title = 'Billet simple pour l\'Alaska - Commentaires signalés'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<?php
foreach ($comments as $comment)
{
?>
<div class="admin-posts">
    <div class="comments">
        <div class="comment-title">
            <h3><?= ucfirst(htmlspecialchars(utf8_encode($comment->getAuthor()))) ?></h3>
            <div class="admin-toolbar trash">
                <div class="font-awesome-icons button">
                    <a href="index.php?action=deleteComment&amp;id=<?=$comment->getId()?>" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
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