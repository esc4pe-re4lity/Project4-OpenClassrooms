<?php $title = 'Billet simple pour l\'Alaska - Accueil'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<?php
while ($post = $posts->fetch(PDO::FETCH_ASSOC))
{
?>
<div class="admin-posts">
    <div class="posts">
        <div class="post-title">
            <a href="index.php?action=post&amp;id=<?=$post['id']?>">
                <h2><?= htmlspecialchars(utf8_encode($post['title'])) ?></h2>
            </a>
            <div class="admin-toolbar">
                <div class="font-awesome-icons button">
                    <a href="index.php?action=updatePost&amp;id=<?=$post['id']?>" title="Modifier">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="font-awesome-icons button">
                    <a href="index.php?action=deletePost&amp;id=<?=$post['id']?>" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="post-content">
            <p>
                <?=nl2br(utf8_encode($post['excerpt']))?>
                <?php if(strlen($post['content']) >= 255){ ?><a href="index.php?action=post&amp;id=<?=$post['id']?>">[...]</a><?php } ?>
            </p>
            <p>
                <time class="date">
                    <?php $formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,
                                            IntlDateFormatter::SHORT,
                                            'Europe/Paris',
                                            IntlDateFormatter::GREGORIAN);
                    if($post['updated'] == true){
                        $formattedDate =new DateTime($post['updatedDate']);
                        echo 'Modifié le '.$formatter->format($formattedDate);
                    }else{
                        $formattedDate =new DateTime($post['creationDate']);
                        echo $formatter->format($formattedDate);
                    }?>
                </time>
            </p>
        </div>
    </div>
</div>
 <?php
}
?>
    <div class="paging">
        <ul>
<?php
for($i=1; $i<=$paging->getNumberOfPages(); $i++){
?>
            <li class="button"><a href="index.php?action=allPosts&amp;page=<?=$i?>"><?=$i?></a></li>
<?php
}
?>
        </ul>
    </div>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    $('a').filter('[title="Supprimer"]').click(confirmDelete);
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>