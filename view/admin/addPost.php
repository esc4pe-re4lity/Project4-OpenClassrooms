<?php $title = 'Billet simple pour l\'Alaska - Nouvel article'; ?>


<?php require('header.php'); ?>


<?php ob_start();?>
<form method="post" id="text-editor" action="index.php?action=addPost">
    <p>
        <input type="texte" name="title" id="title" placeholder="Titre" required/>
    </p>
    <p>
        <textarea name="content" id="content" placeholder="Ecrivez ici..." class="wysiwyg-editor"></textarea>
    </p>
    <p><input class="button" type="submit" value="Envoyer"/></p>
</form>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    window.onload = function(){
        var formElt = document.querySelector("form"),
            titleElt = formElt.title;
    
        $('input').filter('[type="submit"]').click(confirmSubmit);
        $('input').filter('[type="submit"]').keypress(confirmSubmit);

        titleElt.addEventListener("focus",function(){
            window.addEventListener("beforeunload",confirmExit);
        });
        titleElt.addEventListener("blur",function(){
            window.addEventListener("beforeunload",confirmExit);
        });
        tinymce.activeEditor.on("focus",function(){
            window.addEventListener("beforeunload",confirmExit);
        });
        tinymce.activeEditor.on("blur",function(){
            window.addEventListener("beforeunload",confirmExit);
        });
    };
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>
