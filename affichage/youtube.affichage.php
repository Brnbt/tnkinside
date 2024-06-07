<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Dernières Vidéos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="videos">
            <div class="video-large" data-video-id="kcdVpm9osgU">
                <img src="https://img.youtube.com/vi/kcdVpm9osgU/maxresdefault.jpg" alt="IEM Dallas Highlights">
                <p>22/23シーズンの新しいホームジャージをご覧ください⬛️⬜️</p>
            </div>
            <div class="video-small-container">
                <div class="video-small" data-video-id="NQutuswgVxE">
                <img src="https://img.youtube.com/vi/NQutuswgVxE/maxresdefault.jpg" alt="IEM Dallas Highlights">
                    <p>ANKARA | EPISODE 6 (FIFA 22)</p>
                </div>
                <div class="video-small" data-video-id="ZbCM87Qdq8g">
                <img src="https://img.youtube.com/vi/ZbCM87Qdq8g/maxresdefault.jpg" alt="IEM Dallas Highlights">
                    <p>3ARBI CAPABLE | EPISODE 5 (FIFA 22)</p>
                </div>
            </div>
        </div>
    </div>

    <div id="video-popup" class="popup2">
        <div class="popup-content2">
            <span class="close-btn">&times;</span>
            <iframe id="video-iframe" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>

<style>
/* Styles existants */

.container {
    width: auto;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    color: white;
}

.videos {
    display: flex;
    gap: 20px;
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
}

.video-large {
    flex: 2;
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    cursor: pointer;
    color: white;
    transition: transform 0.7s;

}

.video-small-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex: 1;
}

.video-small {
    border: 1px solid #1d2026;
    background-color: #0d0f13;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    cursor: pointer;
    color: white;
    transition: transform 0.2s;

}

.video-small:hover, .video-large:hover{
    transform: scale(1.03);

}

.video-large img, .video-small img {
    width: 100%;
    height: auto;
}

.video-large p, .video-small p {
    padding: 10px;
    margin: 0;
    text-align: center;
    align-items: center;
}

.popup2 {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
}

.popup-content2 {
    position: relative;
    width: auto;
    max-width: 800px;
    background-color: #0d0f13;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
    color: white;
}

/* Responsive Design */

@media (max-width: 768px) {
    .videos {
        flex-direction: column;
        gap: 10px;
    }
    
    .video-large, .video-small-container {
        flex: 1;
    }
    
    .video-small {
        flex-direction: row;
    }
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('.video-large, .video-small');
    const popup = document.getElementById('video-popup');
    const iframe = document.getElementById('video-iframe');
    const closeBtn = document.querySelector('.close-btn');

    videos.forEach(video => {
        video.addEventListener('click', function() {
            const videoId = this.getAttribute('data-video-id');
            iframe.src = `https://www.youtube.com/embed/${videoId}`;
            popup.style.display = 'flex';
        });
    });

    closeBtn.addEventListener('click', function() {
        popup.style.display = 'none';
        iframe.src = '';
    });

    window.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
            iframe.src = '';
        }
    });
});

</script>