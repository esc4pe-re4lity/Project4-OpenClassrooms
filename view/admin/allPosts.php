<?php $title = 'Billet simple pour l\'Alaska - Accueil'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<?php
foreach ($posts as $post)
{
?>
<div class="admin-posts">
    <div class="posts">
        <div class="post-title">
            <a href="index.php?action=post&amp;id=<?=$post->getId()?>">
                <h2><?= htmlspecialchars(utf8_encode($post->getTitle())) ?></h2>
            </a>
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
                <?=nl2br(utf8_encode($post->getExcerpt()))?>
                <?php if(strlen($post->getContent()) >= 255){ ?><a href="index.php?action=post&amp;id=<?=$post->getId()?>">[...]</a><?php } ?>
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