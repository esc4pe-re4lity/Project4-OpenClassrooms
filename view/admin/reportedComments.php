<?php $title = 'Billet simple pour l\'Alaska - Commentaires signalés'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<?php
while ($comment = $comments->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="admin-posts">
    <div class="comments">
        <div class="comment-title">
            <h3><?= ucfirst(htmlspecialchars(utf8_encode($comment['author']))) ?></h3>
            <div class="admin-toolbar trash">
                <div class="font-awesome-icons button">
                    <a href="index.php?action=deleteComment&amp;id=<?=$comment['id']?>" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="comment-content">
            <p>
                <?= nl2br(htmlspecialchars(utf8_encode($comment['content']))) ?>
            </p>
            <p>
                <time class="date">
                    <?php $formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                                            IntlDateFormatter::SHORT,
                                            'Europe/Paris',
                                            IntlDateFormatter::GREGORIAN);
                    $formattedDate =new DateTime($comment['creationDate']);
                    echo $formatter->format($formattedDate); ?>
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
    $('i').filter('[class="fa fa-trash"]').click(confirmDelete);
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>