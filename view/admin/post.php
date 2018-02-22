<?php $title = 'Billet simple pour l\'Alaska - Article'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<?php
while ($data = $post->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="admin-posts">
    <div class="posts">
        <div class="post-title">
            <h2><?= htmlspecialchars(utf8_encode(($data['title']))) ?></h2>
            <div class="admin-toolbar">
                <div class="font-awesome-icons button">
                    <a href="index.php?action=updatePost&amp;id=<?=$data['id']?>" title="Modifier">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="font-awesome-icons button">
                    <a href="index.php?action=deletePost&amp;id=<?=$data['id']?>" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="post-content">
            <p>
                <?=nl2br(utf8_encode($data['content']))?>
            </p>
            <p>
                <time class="date">
                    <?php $formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                                            IntlDateFormatter::SHORT,
                                            'Europe/Paris',
                                            IntlDateFormatter::GREGORIAN);
                    if($data['updated'] == true){
                        $formattedDate =new DateTime($data['updatedDate']);
                        echo 'Modifié le '.$formatter->format($formattedDate);
                    }else{
                        $formattedDate =new DateTime($data['creationDate']);
                        echo $formatter->format($formattedDate);
                    }?>
                </time>
            </p>
        </div>
    </div>
</div>
<form class="add-comment" method="post" action="index.php?action=addComment&idPost=<?= $data['id'] ?>">
    <p>
        <textarea name="content" placeholder="Ecrivez votre commentaire" required></textarea>
    </p>
    <p><input class="button" type="submit" value="Envoyer"/></p>
</form>
<?php
}
while ($comment = $comments->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="comments">
    <h3><?= ucfirst(htmlspecialchars(utf8_encode($comment['author']))) ?></h3>
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