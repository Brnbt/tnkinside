<section class="history-section">
    <div class="content">
        <h1>TNK</h1>
        <p>Depuis sa création en 2020, la Tanuki est passé par de nombreux moments bons et moins bons. Du premier jour du Club aux derniers succès, retrouvez les statistiques de la TNK. Pour plus d'infos, cliquez ici.</p>
        <a href="stats.php" class="about-button">Découvrir →</a>
    </div>
    <div class="image">
        <img id="dynamicImage" src="img/tnklogo.png" alt="Player with soccer ball">
    </div>
</section>

<script>
    const images = [
        'img/tnklogo.png',
        'img/imgteam/tnk2020.png', // Remplace par les chemins de tes images
        'img/imgteam/tnk2021.png',
    ];

    let currentIndex = 0;
    const imgElement = document.getElementById('dynamicImage');

    function changeImage() {
        imgElement.classList.add('fade-out');
        setTimeout(() => {
            currentIndex = (currentIndex + 1) % images.length;
            imgElement.src = images[currentIndex];
            imgElement.classList.remove('fade-out');
            imgElement.classList.add('fade-in');
        }, 500); // Durée de l'effet de fondu
    }

    imgElement.addEventListener('animationend', () => {
        imgElement.classList.remove('fade-in');
    });

    setInterval(changeImage, 4000); // Change l'image toutes les 4 secondes
</script>

<style>
.history-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 2px solid #1d2026;
    background-image: url('https://static.vecteezy.com/system/resources/previews/015/119/497/non_2x/fog-ambient-long-black-background-free-png.png');
    background-size: cover;
    background-position: center;
    padding: 50px;
    height: 50vh;
    width: 97%;
    margin: auto;
    border-radius: 8px;
    transition: transform 0.7s;
}

.history-section:hover {
    transform: scale(1.01);
}

.content {
    max-width: 50%;
}

h2 {
    font-size: 2rem;
    margin-bottom: 10px;
}

h1 {
    font-size: 3rem;
    margin-bottom: 20px;
    font-family: 'Krona One', sans-serif;
}

p {
    font-size: 1rem;
    margin-bottom: 30px;
    line-height: 1.5;
}

.about-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #daf37c;
    color: black;
    text-decoration: none;
    font-size: 1rem;
    border-radius: 5px;
    transition: transform 0.3s;
}

.about-button:hover {
    transform: scale(1.03);
}

.image {
    max-width: 20%;
}

.image img {
    width: 90%;
    border-radius: 10px;
    transition: opacity 0.5s ease-in-out;
}

.fade-out {
    opacity: 0;
}

.fade-in {
    opacity: 1;
}

/* Media Queries for Mobile Devices */
@media (max-width: 768px) {
    .history-section {
        flex-direction: column;
        align-items: center;
        height: auto;
        padding: 20px;
    }

    .content {
        max-width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }

    h1 {
        font-size: 2rem;
    }

    p {
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .about-button {
        font-size: 0.9rem;
        padding: 8px 16px;
    }

    .image {
        max-width: 50%;
    }
}

@media (max-width: 480px) {
    .history-section {
        padding: 10px;
    }

    h1 {
        font-size: 1.5rem;
    }

    p {
        font-size: 0.8rem;
    }

    .about-button {
        font-size: 0.8rem;
        padding: 6px 12px;
    }

    .image {
        max-width: 70%;
    }
}
</style>
