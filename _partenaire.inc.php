<section id=''>
  <div class="partenairesindex">
    <div class="partenaire">
      <img src="img/bolistas.png" alt="bolistas">
    </div>
    <div class="partenaire">
      <img src="img/imgsponsor/logonike.png" alt="partenaire2">
    </div>
    <div class="partenaire">
      <img src="img/imgsponsor/prodirectsoccerlogo.png" alt="partenaire3">
    </div>
  </div>
</section>

<style>


.partenairesindex {
    display: flex;
    overflow: hidden; 
    width: 100%;
    height: 100px; 
    position: relative;
}

.partenairesindex .partenaire {
    flex: 0 0 auto;
    width: 200px; 
    margin: 0 10px; 
}

.partenairesindex img {
    width: 100%;
    height: auto;
}

@keyframes defilement {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

.partenairesindex {
    display: flex;
    animation: defilement 50s linear infinite;
}

</style>
