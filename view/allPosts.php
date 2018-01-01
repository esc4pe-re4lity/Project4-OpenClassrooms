<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    </head>
        
    <body>
        <header>
            <?= $header ?>
        </header>
        <section>
            <?php
while ($post = $posts->fetch(PDO::FETCH_ASSOC))
{
?>
            <div class="posts">
                <h2><?= htmlspecialchars(utf8_encode($post['title'])) ?></h2>
                <p>
                    <?= nl2br(htmlspecialchars(utf8_encode($post['content']))) ?>
                    <br />
                    <span class="date"><?= $post['date'] ?></span>
                    <a href="index.php?action=post&amp;id=<?= $post['id'] ?>">Commentaires</a>
                </p>
            </div>
<?php
}
?>
        </section>
    </body>
</html>