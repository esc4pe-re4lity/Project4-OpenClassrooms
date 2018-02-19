<?php $title = 'Billet simple pour l\'Alaska - Modification article'; ?>


<?php require('header.php'); ?>


<?php ob_start();
while ($data = $post->fetch(PDO::FETCH_ASSOC))
{
?>
<form method="post" id="text-editor" action="index.php?action=updatePost&amp;id=<?=$data['id']?>">
    <p>
        <input type="texte" name="title" id="title" placeholder="Titre" value="<?=htmlspecialchars(utf8_encode(($data['title'])))?>" required/>
    </p>
    <p>
        <textarea name="content" id="content" placeholder="Ecrivez ici..." class="wysiwyg-editor"><?=nl2br(utf8_encode($data['content']))?></textarea>
    </p>
    <p><input class="button" type="submit" value="Envoyer"/></p>
</form>
<?php
}
?>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
    window.onload = function(){
        var formElt = document.querySelector("form"),
            titleElt = formElt.title,
            titleValue = document.getElementById("title").textContent,
            contentValue = tinyMCE.activeEditor.getContent({format: 'text'}).trim();
    
        $('input').filter('[type="submit"]').click(confirmSubmit);
        $('input').filter('[type="submit"]').keypress(confirmSubmit);

        titleElt.addEventListener("input",function(e){
            if(titleValue === e.target.value){
            }else{
                window.addEventListener("beforeunload",confirmExit);
            }
        });
        titleElt.addEventListener("blur",function(e){
            if(titleValue === e.target.value){
            }else{
                window.addEventListener("beforeunload",confirmExit);
            }
        });
        tinymce.activeEditor.on("input",function(e){
            if(contentValue === e.target.value){
            }else{
                window.addEventListener("beforeunload",confirmExit);
            }
        });
        tinymce.activeEditor.on("blur",function(e){
            if(contentValue === e.target.value){
            }else{
                window.addEventListener("beforeunload",confirmExit);
            }
        });
    };
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>