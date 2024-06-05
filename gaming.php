<?php include_once 'affichage/_nav.php'; ?>

<title>Gaming | Site Officiel TNK inside</title>
<h1 id="titre">GAMING</h1>

<h2 id="titre">JEUX ESPORT OÙ TES CHANCES DE GAGNER SONT LIMITÉES CONTRE NOUS</h2>

<div id="sectionjeux">
    <div class="groupejeux">
        <div class="jeux" data-title="THE BEST IS : FAOUZI">
            <a href="#"><img src="img/imgjeux/counterstrikelogo.png" alt="Image 1"></a>
        </div>
        <div class="jeux"  data-title="THE BEST IS : AMINCOWSTA">
            <a href="https://www.ea.com/fr-fr/games/ea-sports-fc/clubs/overview?clubId=2185291&platform=common-gen5" target="_blank"><img src="img/imgjeux/fc24logo.png" alt="Image 1"></a>
        </div>
        <div class="jeux" data-title="KENZY" >
            <a href="https://rocketleague.tracker.network/rocket-league/profile/epic/Kenzy95100/overview" target="_blank"><img src="img/imgjeux/rllogo.png" alt="Image 3"></a>
        </div>
        <div class="jeux"data-title="KENZY">
            <a href="https://www.op.gg/summoners/euw/kenzy95-EUW" target="_blank"><img src="img/imgjeux/lollogo.png" alt="Image 4"></a>
        </div>
        <div class="jeux">
            <a href="#"><img src="img/imgjeux/fortnitelogo.png" alt="Image 3"></a>
        </div>
    </div>

    <div class="groupejeux" data-title="ZOLA">
        <div class="jeux">
            <a href="#"><img src="img/imgjeux/tftlogo.png" alt="Image 3"></a>
        </div>
        <div class="jeux" data-title="BRN">
            <a href="https://tracker.gg/brawlhalla/profile/8623963/overview" target="_blank"><img src="img/imgjeux/brawlhallalogo.png" alt="Image 2"></a>
        </div>
        <div class="jeux" data-title="ZOLA">
            <a href="#"><img src="img/imgjeux/fighterzlogo.png" alt="Image 2"></a>
        </div>
        <div class="jeux" data-title="FAOUZI">
            <a href="#"><img src="img/imgjeux/valorantlogo.png" alt="Image 4"></a>
        </div>
    </div>
    <div class="groupejeux" data-title="KENZY">

    </div>
</div>

<?php include_once 'affichage/_fin.inc.php'; ?>

<style>
    
#sectionjeux{
    margin: auto;
    display: block;
    margin-left: 7%;
}

.groupejeux {
    display: flex;
    justify-content: space-around;
    padding-bottom: 45px;
}

.jeux {
    display: flex;
    justify-content: center;
    position: relative;
    align-items: center; 

}

.jeux img {
    max-width: 60%;
    height: auto;
    transition: transform 0.3s ease-in-out;
    border-radius: 15px;

}

.jeux:hover img {
    transform: scale(1.1);
    filter: brightness(25%);
    transition: all 0.9s ease ;


}

/* .jeux::after {
    content: attr(data-title);
    position:absolute ;
    bottom: 50%;
    left: 0;
    color: #fff;
    text-align: center;
    font-size: 20px;
    opacity: 0;
    pointer-events: none; 
    transition: opacity 0.3s ease;
}  */

.jeux:hover::after {
    opacity: 1;
}

</style>

