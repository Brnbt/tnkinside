<?php include_once 'affichage/_debut.inc.php'; ?>

<title>Accueil | Site Officiel TNK inside</title>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<style>
    body {
        user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -webkit-user-drag: none;
    }

    video {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%; 
   height: auto; 
   z-index: -1; 
}

</style>

<section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
    <?php include_once 'affichage/boutique.affichage.php'; ?>
</section>

<section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
<?php include_once 'affichage/_match.affichage.php'; ?>
</section>

<section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
    <?php include_once 'affichage/_actualite.affichage.php'; ?>
</section>

<section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
    <?php include_once 'affichage/boutique2.affichage.php'; ?>
</section>

<!-- <section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
    <?php include_once 'affichage/histoire.affichage.php'; ?>
</section> -->

<section id="mediacalenderhide" style="border-bottom: 1px solid #1d2026;">
    <?php include_once 'affichage/youtube.affichage.php'; ?>
</section>

<?php include_once 'affichage/_fin.inc.php'; ?>
