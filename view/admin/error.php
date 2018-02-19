<?php $title = 'Billet simple pour l\'Alaska - Erreur'; ?>


<?php require('header.php'); ?>


<?php ob_start(); ?>
<div id="error">
    <h2>ERREUR</h2>
    <p>
        Nous sommes vraiment désolé mais voici la raison de votre problème :<br/>
        <?=$e->getMessage()?>
    </p>
    <img alt="sorry-image" src="public/images/cutenessOverload.png" id="error-image"/>
</div>
<?php $section = ob_get_clean(); ?>


<?php  ob_start(); ?>
<script>
    var i = 0;
    $('i').filter('[class="fa fa-user-circle"]').click(displayNav);
</script>
<?php $script = ob_get_clean(); ?>


<?php require('template.php'); ?>